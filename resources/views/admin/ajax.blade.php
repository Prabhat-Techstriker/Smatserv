<!-- 
    @foreach ($providers as $user)
        <tr>
            <td>{{$user->user->name}}</td>
            <td>{{$user->user->email}}</td>
            <td>{{$user->user->phone_number ? $user->user->phone_number : '-'}}</td>
            <td>{{isset($user->service_provide_type) ? $user->service_provide_type : ''}}</td>
            <td>{{$user->user->latitude}}</td>
            <td>{{$user->user->longitude}}</td>
            <td>{{$user->user->address}}</td>
            @if($user->user->admin_approved == 0)
                <td id="status_{{$user->id}}"><span class="badge badge-secondary">Pending</span></td>
            @else
                <td id="status_{{$user->id}}"><span class="badge badge-info">Approve</span></td>
            @endif
            <td id="change_status_{{$user->id}}"><a href="javascript:" class="badge {{$user->admin_approved ? 'badge-danger' : 'badge-success'}}" onclick="update_status('{{$user->id}}','{{$user->admin_approved ? 0 : 1}}')">{{$user->admin_approved ? 'Disapprove' : 'Approve'}}</a></td>
        </tr>
    @endforeach
 -->