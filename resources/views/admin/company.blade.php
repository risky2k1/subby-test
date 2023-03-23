
<table>
    <tr>
        <th>Company</th>
        <th>Subscribe</th>
        <th>Subscribing to</th>
    </tr>
    @foreach($companies as $company)
    <tr>
            <td>
                {{$company->name}}
                <br>
                <a href="tel:{{$company->phone}}">{{$company->phone}}</a>
                <br>
                <a href="mailto:{{$company->email}}">{{$company->email}}</a>
            </td>
            <td>
                <form  action="{{ route('admin.company.subscribe') }}" method="post">
                    @csrf
                    <input type="hidden" name="company_id" value="{{ $company->id }}">
                    <button type="submit" name="plan" value="1">6 Months</button>
                    <button type="submit" name="plan" value="3">12 Months</button>
                </form>
            </td>
{{--        <td>--}}
{{--                @if(session('end_at'))--}}
{{--                    <p> {{ session('end_at') }}</p>--}}
{{--                @endif--}}
{{--        </td>--}}
    </tr>
    @endforeach
</table>

