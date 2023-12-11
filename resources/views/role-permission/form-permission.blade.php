<?php
        $id = $id ?? null; 

      ?>
@if(isset($id))
{!! Form::model($data, ['route' => ['permission.update', $id], 'method' => 'patch' ]) !!}
@else
{!! Form::open(['route' => ['permission.store'], 'method' => 'post']) !!}
@endif
<div class="form-group">
    <label class="form-label">permission title</label>
    {{ Form::text('title', old('title'), ['class' => 'form-control','id' => 'permission-title', 'placeholder' => 'Permission Title', 'required']) }}
</div>
<div class="form-group">
    <label class="form-label">permission Name</label>
    {{ Form::text('name', old('name'), ['class' => 'form-control','id' => 'permission-name', 'placeholder' => 'Permission Name', 'required']) }}
</div>
<div class="form-group">
    <label class="form-label">permission type</label>
    {{Form::select('type', $typeOptions , old('type'), ['class' => 'form-control', 'placeholder' => 'Select Permission Type'])}}
</div>
<button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
{{ Form::close() }}
