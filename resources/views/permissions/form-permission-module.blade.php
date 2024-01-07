<?php
        $id = $id ?? null; 
      ?>
@if(isset($id))
{!! Form::model($data, ['route' => ['permission.update', $id], 'method' => 'patch' ]) !!}
@else
{!! Form::open(['route' => ['permission.store'], 'method' => 'post']) !!}
@endif
@if($type == 'menu')
<div class="form-group">
    <label class="form-label">Select Modul</label>
    <select class="form-select" name="parent_id" aria-label="Default select example">
        @foreach($module as $modul)
        <option value="{{ $modul->id}}">{{$modul->title }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label class="form-label">Route</label>
    {{ Form::text('url', old('url'), ['class' => 'form-control','id' => 'permission-url', 'placeholder' => 'Route', 'required']) }}
</div>
@endif

<div class="form-group">
    <label class="form-label">Permission Title</label>
    {{ Form::text('title', old('title'), ['class' => 'form-control','id' => 'permission-title', 'placeholder' => 'Permission Title', 'required']) }}
</div>
<div class="form-group">
    <label class="form-label">Permission Name</label>
    {{ Form::text('name', old('name'), ['class' => 'form-control','id' => 'permission-name', 'placeholder' => 'Permission Name', 'required']) }}
</div>
@if($type != 'other')
<div class="form-group">
    <label class="form-label">Order</label>
    {{ Form::number('order', old('order'), ['class' => 'form-control','id' => 'permission-name', 'placeholder' => 'Order', 'required']) }}
</div>
@endif
<input type="hidden" name="type" class="form-control" value="{{ $type ?? ''}}">

<button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
{{ Form::close() }}
