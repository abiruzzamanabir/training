<u>
    <h4 class="text-center">Your Information</h4>
</u>
<table class="table">
    <tbody>
            <tr>
                <td>Serial Number: </td>
                <td class="text-end">1</td>
            </tr>
        <tr>
            <td>Name: </td>
            <td class="text-end">{{$name}}</td>
        </tr>
        <tr>
            <td>Email: </td>
            <td class="text-end">{{$email}}</td>
        </tr>
        <tr>
            <td>Phone: </td>
            <td class="text-end">{{$phone}}</td>
        </tr>
    </tbody>
</table>

@foreach (json_decode($members) as $index => $member)
    <table class="table">
        <tbody>
            <tr>
                <td>Serial Number: </td>
                <td class="text-end">{{$index + 2}}</td>
            </tr>
            <tr>
                <td>Name: </td>
                <td class="text-end">{{$member->member_name}}</td>
            </tr>
            <tr>
                <td>Email: </td>
                <td class="text-end">{{$member->member_email}}</td>
            </tr>
            <tr>
                <td>Phone: </td>
                <td class="text-end">{{$member->member_contact}}</td>
            </tr>
        </tbody>
    </table>
@endforeach
