@can('view_survey_detail')
    <a title="View survey details" href="{{ route('admin.survey.show', ['id' => $id]) }}" class="btn btn-info btn-circle">
        <i class="fas fa-eye"></i>
    </a>
@endcan
