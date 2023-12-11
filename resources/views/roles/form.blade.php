<x-app-layout :assets="$assets ?? []">
    <div>
        <?php
         $id = $id ?? null;
         
      ?>
        @if(isset($id))
        {!! Form::model($data, ['route' => ['role.update', $id], 'method' => 'patch' ]) !!}
        @else
        {!! Form::open(['route' => ['role.store'], 'method' => 'post']) !!}
        @endif
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                        </div>
                        <div class="card-action">
                            <a href="{{route('role.index')}}" class="btn btn-sm btn-primary" role="button">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="uname">Role Name : <span class="text-danger">*</span></label>
                                    {{ Form::text('name', old('name'), ['class' => 'form-control', 'required','placeholder' => 'Enter Role Name']) }}
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="title">Title : <span class="text-danger">*</span></label>
                                    {{ Form::text('title', old('title'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter Title']) }}
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{$id !== null ? 'Update' : 'Add' }} Role</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</x-app-layout>
