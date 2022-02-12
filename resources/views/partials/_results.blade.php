<div class="container fixed" style="display:block">
    <div class="table-wrapper">
        <table class="fl-table">
        <thead>
        <tr class="bg-danger">
            <th>Repo Name</th>
            <th>Repo Description</th>
            <th>Stargaze Count</th>
            <th>View</th>
        </tr>
        </thead>
        <tbody>
        @foreach($results as $result)
            <tr>
                <td>{{$result->name}}</td>
                <td>{{$result->description}} </td>
                <td>{{$result->stargazers_count}}</td>
                <td><a href="{{$result->html_url}}" target="_blank">View Repo</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    <div class="back-button-div">
        <a class="button" href="/">Back to search</a>
    </div>
</div>
