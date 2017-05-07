@extends('layouts.app')

@section('title'){{trans('post.create.title')}}@stop

@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.1/css/bootstrapValidator.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
      rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="{!! asset('css/sweetalert.min.css') !!}"/>
<style>
    .bootstrap-tagsinput {
        width: 100% !important;
    }
</style>
@endpush

@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.1/js/bootstrapValidator.min.js"></script>
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="{!! asset('js/sweetalert.min.js') !!}"></script>
<script>
    $(document).ready(function () {
        $defaultForm = $('#defaultForm');

        $defaultForm
                .bootstrapValidator({
                    excluded: ':disabled',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        title: {
                            validators: {
                                notEmpty: {
                                    message: "{{trans('post.create.valid.title.empty')}}"
                                },
                                stringLength: {
                                    min: 1,
                                    max: 200,
                                    message: "{{trans('post.create.valid.title.length')}}"
                                }
                            }
                        },
                        body: {
                            validators: {
                                callback: {
                                    message: "{{trans('post.create.valid.body.empty')}}",
                                    callback: function (value, validator, $field) {
                                        tinymce.triggerSave();

                                        var text = tinymce.activeEditor.getContent({
                                            format: 'text'
                                        });

                                        return Boolean(text);
                                    }
                                }
                            }
                        },
                        created_at: {
                            validators: {
                                date: {
                                    format: 'YYYY-MM-DD HH:mm:ss',
                                    message: "{{trans('post.create.valid.created_at.date')}}"
                                },
                                notEmpty: {
                                    message: "{{trans('post.create.valid.created_at.empty')}}"
                                }
                            }
                        }
                    }
                })
                .on('success.form.bv', function (e) {
                    e.preventDefault();
                    $this = $(this);
                    var formData = new FormData(document.forms.defaultForm);

                    $.ajax({
                        type: $this.attr('method'),
                        dataType: 'JSON',
                        data: formData,
                        url: $this.attr('action'),
                        contentType: false,
                        processData: false,
                        success: function () {
                            swal({
                                title: "{{trans('post.create.success.title')}}",
                                text: "{{trans('post.create.success.text')}}",
                                type: 'success',
                                confirmButtonColor: '#82d1ff',
                                confirmButtonText: "{{trans('post.create.success.confirm')}}"
                            }, function () {
                                window.location = "{{url('post')}}"
                            });
                        },
                        error: function (response) {
                            response = response.responseJSON;
                            var errors = response.errors, errorsText = '';

                            for (var e in errors)
                                errorsText += '<p><span style="color:#F8BB86">' + e + '</span>: ' + errors[e] + '</p>';

                            swal({
                                animation: 'slide-from-top',
                                html: true,
                                title: "{{trans('post.create.error.title')}}",
                                text: errorsText,
                                type: 'warning',
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonColor: '#428bca',
                                confirmButtonText: "{{trans('post.create.error.confirm')}}",
                                closeOnConfirm: true
                            });
                        }
                    });
                });

        $('#datetimePicker input').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'}).on('dp.change', function (ev) {
            $defaultForm.bootstrapValidator('revalidateField', 'created_at');
        });

        tinymce.init({
            selector: 'textarea#body',
            setup: function (editor) {
                editor.on('keyup', function (e) {
                    $defaultForm.bootstrapValidator('revalidateField', 'body');
                });
            }
        });
    });
</script>
@endpush

@section('content')
    <div class="container">
        <h2>{{trans('post.create.title')}}</h2>
        <div class="row">
            <div class="col-sm-2 col-lg-2"></div>
            <div class="col-sm-8 col-lg-8">
                <form id="defaultForm" method="post" action="{{url('post')}}" class="form-horizontal"
                      enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label">{{trans('post.create.part.title')}}</label>
                        <input type="text" name="title" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{trans('post.create.part.body')}}</label>
                        <textarea name="body" id="body" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{trans('post.create.part.image')}}</label>
                        <input type="file" name="image" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{trans('post.create.part.tags')}}</label>
                        <select multiple name="tags[]" class="form-control" data-role="tagsinput"></select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{trans('post.create.part.created_at')}}</label>
                        <div class="dateContainer">
                            <div class="input-group date" id="datetimePicker">
                                <input type="text" class="form-control" name="created_at"
                                       placeholder="YYYY-MM-DD HH:mm:ss"/>
                                <span class="input-group-addon"><span
                                            class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-5 col-lg-offset-3">
                            <button type="submit" class="btn btn-default">{{trans('post.create.part.create')}}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-2 col-lg-2"></div>
        </div>
    </div>
@endsection
