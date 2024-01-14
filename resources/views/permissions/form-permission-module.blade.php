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
        @foreach($parents as $modul)
        @if($modul->parent_id !== null)
        <option value="{{ $modul->id }}" {{ isset($data) && $modul->id == $data->parent_id ? 'selected' : '' }}>{{ $modul->title }} -
            @isset($locations)
            @foreach($locations as $location)
            {{ $modul->parent_id !== null && $modul->parent_id == $location->id ? $location->title : '' }}
            @endforeach
            @endisset
        </option>
        @endif
        @endforeach
    </select>
</div>

<div class="form-group">
    <label class="form-label">Route</label>
    {{ Form::text('url', old('url'), ['class' => 'form-control','id' => 'permission-url', 'placeholder' => 'Route' ]) }}
</div>
@endif

@if($type == 'module')
<div class="form-group">
    <label class="form-label">Select Location</label>
    <select class="form-select" name="parent_id" aria-label="Default select example">
        @foreach($parents as $location)
        <option value="{{ $location->id }}" {{ isset($data) && $location->id == $data->parent_id ? 'selected' : '' }}>{{ $location->title }}
        </option>
        @endforeach
    </select>
</div>
@endif

<div class="form-group">
    <label class="form-label">{{ ucfirst($type) ?? 'Permission'}} Title</label>
    {{ Form::text('title', old('title'), ['class' => 'form-control','id' => 'permission-title', 'placeholder' => ucfirst($type) . ' Title', 'required', 'autocomplete' => 'off']) }}
</div>
<div class="form-group">
    <label class="form-label">{{ ucfirst($type) ?? 'Permission'}} Name</label>
    {{ Form::text('name', old('name'), ['class' => 'form-control','id' => 'permission-name', 'placeholder' => ucfirst($type) . ' Name', 'required', 'autocomplete' => 'off']) }}
</div>
@if($type == 'module')
<div class="form-group">
    <label class="form-label">Alias</label>
    {{ Form::text('aliases', old('aliases'), ['class' => 'form-control','id' => 'permission-name', 'placeholder' => 'BP', 'autocomplete' => 'off']) }}
</div>
@endif
@if($type != 'other')
<div class="form-group">
    <label class="form-label">Order</label>
    {{ Form::number('order', old('order'), ['class' => 'form-control','id' => 'permission-name', 'placeholder' => 'Order', 'autocomplete' => 'off']) }}
</div>
@endif
<input type="hidden" name="type" class="form-control" value="{{ $type ?? ''}}">

<button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>

{{ Form::close() }}
