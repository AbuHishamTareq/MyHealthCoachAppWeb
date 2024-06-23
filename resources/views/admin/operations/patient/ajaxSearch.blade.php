<table class="table table-striped jambo_table">
    <thead>
        <tr class="headings">
            <th class="column-title">Patient UID</th>
            <th class="column-title">Patient Name</th>
            <th class="column-title">Gender</th>
            <th class="column-title">Age</th>
            <th class="column-title">Complex Name</th>
            <th class="column-title">Health Coach</th>
            <th class="column-title">Mobile</th>
            <th class="column-title">Status</th>
            <th class="column-title no-link last text-center"><span class="nobr">Action</span></th>
        </tr>
    </thead>
    @if ($patients == null || empty($patients))
    <tbody>
        <tr class="even pointer">
            <!-- class="odd pointer" -->
            <td class="text-center text-uppercase" style="font-size: 14px; color: darkred; font-weight: bold;" colspan="9">!! No Patients found !!</td>
        </tr>
    </tbody>
    @else
    <tbody>
        @foreach ($patients as $patient)
        <tr @if ($loop->iteration % 2 == 0) class="even pointer" @else class="odd pointer" @endif>
            <td class=" " style="vertical-align: middle">{{ $patient['uid'] }}</td>
            <td class=" " style="vertical-align: middle">{{ $patient['name'] }}</td>
            <td class=" " style="vertical-align: middle">
                @if ($patient['gender'] == 'M')
                    Male
                @else
                    Female
                @endif
            </td>
            <td class=" " style="vertical-align: middle">{{ \Carbon\Carbon::parse($patient['birth_date'])->diff(\Carbon\Carbon::now())->format('%y years'); }}</td>
            <td class=" " style="vertical-align: middle">{{ $patient['getComplex']['name'] }}</td>
            <td class=" " style="vertical-align: middle">{{ $patient['getCoach']['name'] }}</td>
            <td class=" " style="vertical-align: middle">{{ $patient['mobile'] }}</td>
            <td class="text-center" style="vertical-align: middle">
                @if ($patient['status'] == 1)
                    <a href="javascript:void(0)" class="updatePatientStatus" id="patient-{{ $patient['id'] }}" patient-id= {{ $patient['id'] }}>
                        <i class="fa fa-toggle-on" status="Active" title="Active"></i>
                    </a>
                @elseif ($patient['status'] == 0)
                <a href="javascript:void(0)" class="updatePatientStatus" id="patient-{{ $patient['id'] }}" patient-id= {{ $patient['id'] }}>
                    <i class="fa fa-toggle-off" status="Inactive" title="Inactive"></i>
                </a>
                @endif
            </td>
            <td class="text-center" style="vertical-align: middle">
                <a href="#" title="Add Health Parameters"><i class="fa fa-plus mr-2" style="color: darkblue; font-size: 18px"></i></a>
                <a href="#" title="Edit Patient Information"><i class="fa fa-edit mr-2" style="color: darkgreen; font-size: 18px"></i></a>
                <a href="#" title="View Patient Information"><i class="fa fa-eye mr-2" style="color: darkred; font-size: 18px"></i></a>
                <a href="#" title="Transfer Patient"><i class="fa fa-exchange" style="color: black; font-size: 18px"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
    @endif
</table>
<div id="searchPagination" class="col-md-12 col-sm-12">
    {{ $patients->links() }}
</div>