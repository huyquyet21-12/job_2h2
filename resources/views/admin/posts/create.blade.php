@extends('layout.master')
@push('css')
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<link href="{{ asset('css/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
<style>
    
    .error{
        color: red;
    }

    input[data-switch]:checked + label:after {
        left: 90px;
    }

    input[data-switch] + label {
        width: 110px;
    }
</style>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
            <div id="div-error" class="alert alert-danger d-none"></div>
                <div class="card-body">
                    <form action="{{ route('admin.posts.store') }}" class="form-horizontal" method="POST" id="form-create-post">
                        @csrf
                        <div class="form-group">
                            <label>Company</label>
                            <select name="company" id="select-company" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="">Language (*) </label>
                            <select name="languages[]" id="select-language" class="form-control" multiple>
                                <!-- multiple cho cho duoc nhieu -->
                            </select>
                        </div>
                        <div class="form-row select-location">
                            <div class="form-group col-6">
                                <label for="">City (*)</label>
                                <select name="city" id="select-city" class="form-control select-city"></select>
                            </div>
                            <div class="form-group col-6">
                                <label for="">District</label>
                                <select name="district" id="select-district" class="form-control select-district"></select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-4">
                                <label>Min Salary</label>
                                <input type="number" name="min_salary" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Max Salary</label>
                                <input type="number" name="max_salary" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Currency Salary</label>
                                <select name="currency_salary" id="" class="form-control">
                                    @foreach($currencies as $currency => $value)
                                      <option value="{{ $value }}">
                                         {{ $currency }}
                                      </option>
                                    @endforeach  
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-8">
                                <label>Requirement</label>
                                <textarea name="requirement" id="text-requirement"></textarea>
                            </div>
                            <div class="form-group col-4">
                                <label>Number Applicants</label>
                                <input type="number" name="number_applicants" class="form-control">
                                <br>
                                <select name="remotable" class="form-control">
                                    @foreach($remotables as $key => $val)
                                       <option value="{{ $val }}">
                                           <!-- {{ $key }} -->
                                             {{ __('frontpage.' .strtolower($key)) }}
                                       </option>
                                    @endforeach
                                </select>
                                <br>
                                <input type="checkbox" name="can_parttime" id="can_parttime" checked data-switch="info">
                                <label for="can_parttime" data-on-label="Can Part-time" data-off-label="No Part-time"></label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Title</label>
                                <input type="text" name="job_title" class="form-control" id="job_title">
                            </div>
                            <div class="form-group col-6">
                                <label>Slug</label>
                                <input type="text" name="slug" class="form-control" id="slug">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" id="btn-submit" disabled>Create</button>
                            <!-- mac dinh khong cho disabled -->
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-company" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create Company</h4>
                    <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                      <form id="form-create-company" action="{{ route('admin.companies.store') }}" method="POST" class="form-horizontal"
                      enctype="multipart/form-data">
                        @csrf 
                        <div class="form-group">
                            <label>Company</label>
                            <input readonly name="name" id="company" class="form-control">
                        </div>
                        
                        <div class="form-row select-location">
                            <div class="form-group col-4">
                                <label for="">Country (*)</label>
                                <select name="country" id="country" class="form-control">
                                    @foreach($countries as $val => $name)
                                       <option value="{{ $val }}">
                                         {{ $name }}
                                       </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="">City (*)</label>
                                <select name="city" id="city" class="form-control select-city"></select>
                            </div>
                            <div class="form-group col-4">
                                <label for="">District</label>
                                <select name="district" id="district" class="form-control select-district"></select>
                            </div>
                        </div>  
                        <div class="form-row">
                             <div class="form-group col-6">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control">
                             </div>
                             <div class="form-group col-6">
                                <label>Address2</label>
                                 <input type="text" name="address2" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                             <div class="form-group col-6">
                                <label>ZipCode</label>
                                <input type="number" name="zipcode" class="form-control">
                             </div>
                             <div class="form-group col-6">
                                <label>Phone</label>
                                 <input type="number" name="phone" class="form-control">
                            </div>
                        </div> 
                        <div class="form-row">
                             <div class="form-group col-6">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control">
                             </div>
                             <div class="form-group col-6">
                                <label>Logo</label>
                                <input type="file" name="logo" oninput="pic.src=window.URL.createObjectURL(this.files[0])">
                                <img id="pic" alt="" height="100">
                            </div>
                        </div> 

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="submitForm('company')" class="btn btn-success">Create</button>
                </div>
             </div>
        </div>
    </div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
<!-- dung jquery validation de validate -->
<script>

    function notifySuccess(message = '') {
        $.toast({
            heading: 'Success',
            text: message,
            showHideTransition: 'slide',
            position: 'bottom-right',
            icon: 'success'
        });
    }

    function notifyError(message = '') {
        $.toast({
            heading: 'Error',
            text: message,
            showHideTransition: 'slide',
            position: 'bottom-right',
            icon: 'error'
        });
    }
    // $.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon");
    // notifyError('Day la tinh nang');
    function generateTitle(){
        let languages = [];//mang languages la 1 mang rong
        const selectedLanguage = $("#select-language :selected").map(function(i,v) {
            languages.push($(v).text());
            //nhung gi duoc chon tren thanh #select-language se chay vao ham map va tao 1 ham moi
            //push => them value theo dang text vao
        });
        languages = languages.join(',');
        const city = $("#select-city").val();
        //gia tri cua thanh city khi selected
        const company = $("#select-company").val();
        let title = `(${city}) ${languages}`;
        
        if(company){
            //neu co company
            title += ' - ' + company;
        }

        $("#job_title").val(title);
        generateSlug(title);
        //khi generateTitle => se generateSlug luon
    }

    function generateSlug(title){
        $.ajax({
            url: "{{ route('api.posts.slug.generate') }}",
            type: 'POST',
            dataType: 'json',
            data: { title },
            success: function(response) {
                $("#slug").val(response.data);
                $("#slug").trigger('change');
            },
            error: function(response) {

            }
        })
    }
    async function loadDistrict(parent){
        parent.find(".select-district").empty();
        const path = parent.find(".select-city option:selected").data('path');
        if(!path){
            return;
            //neu khong co duong dan~ => bo
        }
        const response = await fetch("{{ asset('locations/') }}" + path);
        const districts = await response.json();
        let string = '';
        const selectedValue = $("#select-district").val();
        $.each(districts.district, function(index, each) {
            if(each.pre === 'Quận' || each.pre === 'Huyện' || each.pre === 'Thành phố'){
                string += `<option`;
                    if (selectedValue === each.name) {
                        string += ` selected `;
                    }
                    string += `>${each.name}</option>`;
            }
        })
        parent.find(".select-district").append(string);
        }

    function checkCompany(){
        $.ajax({
            url: "{{ route('api.companies.check') }}/" + $("#select-company").val(),
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if(response.data) {
                    //khi da co data trong table
                    submitForm('post');
                } else {
                    $("#modal-company").modal("show");
                    $("#company").val($("#select-company").val());
                    $("#city").val($("#select-city").val()).trigger('change');
                    //kich hoat change => cho biet gia tri da thay doi
                    
                }
            }
        })
    }

    function errorShow(errors){
        let string = `<ul>`;
        if(Array.isArray(errors)) {
            //neu errors la kieu mang
            errors.forEach(function (each, index) {
                each.forEach(function (error) {
                    string += `<li>${error}</li>`;
                });
            });
        } else {
            string += `<li>${errors}</li>`;
        }
        string += `</ul>`;
       
        
        $("#div-error").html(string);
        $("#div-error").removeClass("d-none").show();
        notifyError(string);
    }

    function submitForm(type) {
        const obj = $("#form-create-"+type)
        const formData = new FormData(obj[0]);
        $.ajax({
                url: obj.attr('action'),
                type: "POST",
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                enctype: 'multipart/form-data',
                // lay toan bo thong tin cua form
                success: function (response) {
                    if(response.success){
                        $("#div-error").hide();
                    //neu thanh cong => an dong thong bao loi di
                        $("#modal-company").modal("hide");
                        notifySuccess();
                        // window.location.href = "{{ route('admin.posts.index') }}";
                    } else {
                        errorShow([response.message]);
                        //duoc hieu la truyen 1 mang gom nhung loi vao
                    }
                    
                },
                error: function(response){
                    let errors;
                    if(response.responseJSON.errors){
                        errors = Object.values(response.responseJSON.errors);
                        errorShow(errors);
                        //du lieu loi la 1 object gui sang khi tra ve du lieu
                    } else {
                        errors = response.responseJSON.message;
                        errorShow(errors);
                    }
                },
            });
    }

    $(document).ready(async function() {
        $("#text-requirement").summernote();
        //dung cdk
        $("#select-city").select2({tags: true});//cho nguoi dung nhap hoa tim kiem
        $("#city").select2({tags: true});
        const response = await fetch("{{ asset('locations/Index.json') }}");
        const cities = await response.json();//tra ve cac json co trong response
        $.each(cities,function(index, each){
            $("#select-city").append
            (`<option  data-path='${each.file_path}'>
            ${index}
            </option>`)
            //file_path trong json
            $("#city").append
            (`<option  data-path='${each.file_path}'>
            ${index}
            </option>`)
        })
        $("#select-city, #city").change(function () {
            //khi co su kien change xay ra o cac the co id la select-city va city
            loadDistrict($(this).parents('.select-location'));
            //goi ham loadDistrict
            //$(thís) => phan tu vua duoc thay doi
            //.parents('.select-location') => tim phan tu cha co class la select-location cua phan tu vua duoc thay doi

        });
        $("#select-district").select2({tags: true});
        $("#district").select2({tags: true});

        await loadDistrict($("#select-city").parents('.select-location'));
        
        $("#select-company").select2({
            tags: true,
            //neu nhap 1 gia tri => them moi
            ajax: {
                url: "{{ route('api.companies') }}",
                data: function(params) {
                    //ham dinh nghia cac tham so truy van moi khi nguoi dung gui len sever tim kiem
                    const queryParameters = {
                        q: params.term
                        //params.term là tu khoa nguoi dung nhap vao
                    };

                    return queryParameters;
                },
                processResults: function (data) {
                    //tra du lieu ve theo select2 yeu cau
                    return {
                        results: $.map(data.data, function(item) {
                            //boi vi tra ve json (json la data), trong mang json co data => data.data
                            return {
                                text: item.name ,
                                //hien thi ra ten cua cong ty
                                
                                id: item.name
                                //gia tri truyen sang la ten cua dât
                            }
                        })
                    }
                }
            }
        });
        $("#select-language").select2({
            // tags: true, => khong cho dien
            ajax: {
                
                url: "{{ route('api.languages') }}",
                data: function(params) {
                    const queryParameters = {
                        q: params.term
                    };

                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function(item) {
                            //boi vi tra ve json (json la data), trong mang json co data => data.data
                            return {
                                text: item.name ,
                                id: item.id
                            }
                        })
                    }
                }
            }
        });
        $(document).on('change','#select-language , #select-company , #select-city', function(){
            generateTitle();
        });

        $("#slug").change(function() {
            $("#btn-submit").attr('disabled', true);
            $.ajax({
                url: "{{ route('api.posts.slug.check') }}",
                type: 'GET',
                dataType: 'json',
                data: {slug: $(this).val()},
                success: function (response) {
                    if(response.success) {
                        $("#btn-submit").attr('disabled', false);
                    }
                }
            })
        });

        $("#form-create-post").validate({
            //validate form co id la form-create
            rules: {
                company: {
                    //neu dien form khong kem theo company => se bao loi
                    required: true,
                    
                }
            },
            submitHandler: function() {
                checkCompany();
                
            }
        });
    });
</script>
@endpush