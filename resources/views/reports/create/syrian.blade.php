@extends('layouts.create_report')

@section('page-title-breadcrumb', __('nav.addSyrians'))

@section('page-title', __('nav.addSyrians'))

@section('form-subtitle', __('nav.addSyrians'))

@section('form-action', route('reports.storeSyrians'))

@section('selectBox')
    <label class="control-label">
        @lang('Governorate')
    </label>
    <select class="form-control custom-select @error('governorate_id') is_invalid @enderror"
            data-placeholder="@lang('Select a Governorate')"
            id="governorate_id"
            name="governorate_id"
            required>
        @foreach($governorates as $governorate)
            <option value="{{ $governorate->id }}">
                {{ app()->getLocale() === 'en' ? $governorate->name_en : $governorate->name_ar }}
            </option>
        @endforeach
    </select>
    @error('governorate_id')
        <small class="form-control-feedback">
            {{ $message }}
        </small>
    @enderror
@endsection
