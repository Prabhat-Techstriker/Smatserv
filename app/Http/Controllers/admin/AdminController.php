<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\User_details;
use Edujugon\PushNotification\PushNotification;
use Validator;
use App\Models\Price;
use App\Models\policies;
use App\Models\SupportModel;
use App\Models\PaymentInfo;
use App\Models\Advertisement;
use App\Models\Rating;

class AdminController extends Controller
{

    public function __construct(Request $request){
        $user = Auth::user();
    }

    public function show()
    {
        return view('auth.login');
    }

    public function dashboard()
    {
        $providersApprovalList  = User::where('service_type', 2)->count();
        $paymentInfoList        = PaymentInfo::count();
        $vehiclePriceList       = Price::count();
        $usersprovidersList     = User::count();

        return view('admin.dashboard', ['providersApprovalList' => $providersApprovalList , 'paymentInfoList' => $paymentInfoList , 'vehiclePriceList' => $vehiclePriceList , 'usersprovidersList' => $usersprovidersList]);
    }

    public function providerList(Request $request)
    { 
        $data = User::where('service_type', 2)->with('user_details')->get();
        //print_r($data);die;
        if ($data) {
            return view('admin.providers', ['providers' => $data]);
        }
    }

    public function Support(Request $request){
        $data = SupportModel::with('user')->get();
        return view('admin.support', ['data' => $data]);
    }


    public function allUsers(Request $request){
        $data = User::where('service_type' , 1)->with('user_details')->get();
        if ($data) {
            return view('admin.alluser', ['users' => $data]);
        }
    }

    public function allProviders(Request $request){
        $data = User::where('service_type' , 2)->with('user_details')->get();
        if ($data) {
            return view('admin.allproviders', ['providers' => $data]);
        }
    }

    public function updateStatus(Request $request){
        $userId  = $request->all();
        try {
            $update = User::where('id', $userId['userId'])->update(['admin_approved' => ($userId['status'] ? true : false)]);
            $data = User::where('id', $userId['userId'])->first();
            $dtoken = $data['device_token'];
            //$dtoken = 'eLhwzaj9Rpymgm9gqCXVpB:APA91bFYyMnPpluACzqmplSn29TzlrGRGMLg6UJkMhj-AtmrBMZV2RKrY_podqzYfr0X3thryZizyz7nAK4LIQFdHCHWrJAWgxyt2_xi3YvEO-UU8kmTvulrtKc3K97rl7R1YD3Wz_Qx';

            if ($dtoken && $userId['status'] == true) {
                $message = 'Congratulations your request is approved for service provider.';
                sendPushnotification($dtoken,' Smatserv',$message,'',6);
            }
            return response()->json(['status' => 'success', 'message' => 'data updated successfully!.', 'code' => 200, 'admin_approved' => $data['admin_approved']]);
            
        } catch (Exception $e) {
            
        }
    }

    public function deleteUser(Request $request){
        $data = $request->all();
        
        try {
            $user = User::find($data['userId']);
            $user->user_details()->delete();
            $user->delete();

            return response()->json(['status' => 'success', 'message' => 'deleted successfully!.'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'failed to delete!.'], 409);
        }
    }

    public function addVehicle(Request $request){
        //$data = $request->all();
        //print_r($data);die("---");
        return view('admin.vehicle');
    }

    public function addPrice(Request $request){
        $data = $request->all();
        $results = array();
        $arrayData = array();
        $i = 0;
        foreach ($data['vehicle'] as $key => $value) {
            //print_r($value);
            $results['parent_id']   = $data['category'];
            $results['service']     = $data['vehicle'][$i];
            $results['price']       = $data['price'][$i];
            $results['created_at']  = date('Y-m-d H:i:s');
            $results['updated_at']  = date('Y-m-d H:i:s');
            $arrayData[] = $results;
            $i++;
        }
        
        Price::insert($arrayData); 

        return view('admin.vehicle');
    }

    public function vehiclelist(Request $request){
        if(isset($request->vehiclecategory) && $request->vehiclecategory != ''){
            $query = Price::where('parent_id',$request->vehiclecategory)->get();
        }else{
            $query = Price::where('parent_id',2)->get();
        }

        return view('admin.vehiclelist', ['list' => $query,'queryParam' => $request->vehiclecategory]);
    }

    public function vehicleDelete(Request $request){
        try {
            $query = Price::where('id',$request->id)->delete();
            return response()->json(['status' => 'success', 'message' => 'data delete successfully!.', 'code' => 200]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'unable to delete!.', 'code' => 401]);
        }
    }

    public function vehicleEdit(Request $request,$id){
        $query = Price::where('id',$id)->first();
        return view('admin.listedit', ['vehicle' => $query]);
    }

    public function edit(Request $request){
        $query = Price::where('id',$request->id)->update(['service' => $request->vehicle , 'price' => $request->price]);
        return redirect('admin/vehicle-list')->with('flash.message', 'Post was created!')->with('flash.class', 'success');
    }

    public function privacy_policy(Request $request){
        $query = policies::where('page_name','Privacy policy')->first();
        return view('admin.privacypolicy',['data' => $query]);
    }

    public function addprivacypolicyText(Request $request){
        $data = array('page_name' => 'Privacy policy', 'description' => $request->privacy);
        $user = policies::updateOrCreate(['page_name' => 'privacy-policy'],$data);
        return redirect('admin/privacy-policy');
    }

    public function aboutus(Request $request){
        $query = policies::where('page_name','About us')->first();
        return view('admin.aboutus',['data' => $query]);
    }

    public function addText(Request $request){
        $data = array('page_name' => 'About us', 'description' => $request->aboutus);
        $user = policies::updateOrCreate(['page_name' => 'about-us'],$data);
        return redirect('admin/about-us');
    }

    public function contactus(Request $request){
        $query = policies::where('page_name','contact-us')->first();
        return view('admin.contactus',['data' => $query]);
    }

    public function addContactus(Request $request){
        $data = array('page_name' => 'contact-us', 'description' => $request->contactus);
        $user = policies::updateOrCreate(['page_name' => 'contact-us'],$data);
        return redirect('admin/contact-us');
    }

    public function FAQ(Request $request){
        $query = policies::where('page_name','FAQ')->first();
        return view('admin.FAQ',['data' => $query]);
    }

    public function addFAQText(Request $request){
        $data = array('page_name' => 'FAQ', 'description' => $request->FAQ);
        $user = policies::updateOrCreate(['page_name' => 'FAQ'],$data);
        return redirect('admin/FAQ');
    }

    public function paymentInfo(Request $request){
        $paymentInfo = PaymentInfo::with('user','provider','user_details')->get();
        return view('admin.paymentinfo', ['paymentinfo' => $paymentInfo]);
    }

    public function advertisement(Request $request){
        return view('admin.advertisement');
    }

    public function advertiseUpload(Request $request){
        $request->validate([
            'customFile'    =>  'required|image|mimes:jpeg,png,jpg',
        ]);

        try {
            $device_token = User::where('device_token', '!=', '')->pluck('device_token');

            $filename_withext = $request->file('customFile')->getClientOriginalName();
            $file_name = pathinfo($filename_withext, PATHINFO_FILENAME);            
            $extension_bussi = $request->file('customFile')->getClientOriginalExtension();
            $mimeType = $request->file('customFile')->getClientMimeType();
            $file_name_to_store = str_replace(" ", "-", $file_name).'_'.time().'.'.$extension_bussi;
            $path = $request->file('customFile')->storeAs('advertisement', $file_name_to_store);

            $filepath = Advertisement::create(['file_path' => $path]);
            $storagePath = url('storage/app').'/'.$path;
            $notificationType = 11; // notification type 11 for advertisement
            sendMultiple($device_token, 'Smatserv', 'Advertisement', $storagePath , $notificationType);

            return redirect('admin/advertisement')->with('flash_message', 'Advertisement send successfully to the users and providers!.')->with('flash_type', 'alert-info');
        } catch (Exception $e) {
            return redirect('admin/advertisement')->with('flash_message', 'Something went wrong.please try again!.')->with('flash_type', 'alert-warning');
        }
    }

    public function offersPage(Request $request){
        return view('admin.offerspage');
    }

    public function offers(Request $request){
        try {
            $query = User::where('device_token', '!=', '');
                                    
            switch ($request->sendto) {
                case 1:
                    $notificationType = 12;
                    $query = $query->where('service_type', '=', $request->sendto)->pluck('device_token');
                break;
                case 2:
                    $notificationType = 13;
                    $query = $query->where('service_type', '=', $request->sendto)->pluck('device_token');
                break;
                case 0:
                    $notificationType = 14;
                    $query = $query->pluck('device_token');
                break;
            }

            $senddata = array('title' => $request->title,
                                'text' => $request->textarea
                            );
             
            sendMultiple($query, 'Smatserv', $request->textarea, '' , $notificationType , '');

            return redirect('admin/offerspage')->with('flash_message', 'Offers send successfully to the users/providers!.')->with('flash_type', 'alert-info');
        } catch (Exception $e) {
            return redirect('admin/offerspage')->with('flash_message', 'Something went wrong.please try again!.')->with('flash_type', 'alert-warning');
        }
    }

    public function ratingReview()
    {
        try {
            $results = Rating::with('provider','provider_details','user')->get();

            return view('admin.review',['results' => $results]);
        } catch (Exception $e) {
            
        }
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
