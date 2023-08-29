@extends('Admin.Layouts.master')
@section('content')
    <style>
        .error {
            color: red
        }

        .cover-times.month {
            display: -ms-grid;
            display: grid;
            -ms-grid-columns: (minmax(200px, 1fr))[auto-fit];
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }

        .cover-times {
            display: -ms-grid;
            display: grid;
            -ms-grid-columns: (minmax(130px, 1fr))[auto-fit];
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 10px;
        }

        .cover-times .choose-time {
            position: relative;
            overflow: hidden;
        }

        .cover-times .choose-time input[type=radio],
        .cover-times .choose-time input[type=checkbox] {
            -webkit-appearance: none;
            border: none !important;
            margin: auto;
            position: absolute;
            left: 0px;
            width: 100%;
            height: 100%;
            cursor: pointer;
            opacity: 0;
        }

        .cover-times .choose-time input[type=radio]:checked~label,
        .cover-times .choose-time input[type=checkbox]:checked~label {
            background: rgba(var(--primary-rgb-clr), 0.14);
            border: 1px solid rgba(var(--primary-rgb-clr), 0.14);
        }

        .cover-times .choose-time label {
            color: #4F4F4F;
            font-weight: 400;
            padding: 10px 7px;
            border: 1px solid #EEEEEE;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            text-align: center;
            width: 100%;
            font-size: 14px;
        }

        .cover-image-uploader {
            padding: 15px;
            border: 2px dashed gray;
            height: 180px;
            background: white;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
        }

        .cover-image-uploader .inner-image-uploader p {
            margin-bottom: 0;
            font-size: 20px;
        }

        .cover-image-uploader .inner-image-uploader i {
            font-size: 44px;
            opacity: 0.6;
        }

        .imgThumbContainer {
            display: inline-block;
            -webkit-box-pack: center;
            justify-content: center;
            position: relative;
            border: 1px solid var(--border-clr);
            -webkit-box-shadow: 1px 1px 30px 0 rgb(0 0 0 / 5%);
            box-shadow: 1px 1px 30px 0 rgb(0 0 0 / 5%);
        }

        .RearangeBox {
            width: 180px;
            padding: 10px 5px;
            cursor: all-scroll;
            float: left;
            border: 1px solid #9E9E9E;
            font-family: sans-serif;
            display: inline-block;
            margin: 5px !important;
            text-align: center;
            color: #673ab7;
            background: #fafafa;
        }

        .material-icons {
            font-family: 'Material Icons';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
    </style>
    <div class="page-title d-flex align-items-center justify-content-between flex-wrap">
        <h2>Create New Product</h2>
        <ul class="d-flex align-items-center gap-2">
            <li><a href="{{ route('admin.product.index') }}" class="white-btn left-icon font-weight-500"><i
                        class="material-icons">
                        west
                    </i> Go Back</a></li>
        </ul>
    </div>
    <div class="cover-inner-content">
        <div class="cover-inner-content">
            <div class="card">
                <div class="card-body">
                     <div class="cover-form">
                                <form id="productForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="Enter Product Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Price</label>
                                                <input type="number" class="form-control" id="price" name="price"
                                                    placeholder="Enter Product Price">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="">Description</label>
                                            <textarea class="form-control" name="description" id="description" rows="3"
                                                placeholder="Enter Product Description"></textarea>
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <div class="form-group">
                                                <label for="">Quantity</label>
                                                <input type="number" id="quantity" class="form-control" name="quantity"
                                                    placeholder="Enter Product Quantity">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <div class="form-group">
                                                <label for="">Main Image</label>
                                                <input id="main_img" type="file" class="form-control" name="main_img">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <div class="form-group">
                                                <label for="">Status (Active/Deactive)</label>
                                                <input id="status" type="checkbox"  name="status"
                                                    value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <div class="form-group">
                                                <label for="">Multiple Image Upload</label>
                                                <div class="cover-image-uploader mt-2">
                                                    <label for="files">
                                                        <input id="files" type="file" name="images[]"
                                                            style="display: none;" multiple />
                                                        <div class="inner-image-uploader text-center">
                                                            <div class="row align-items-center h-100">
                                                                <div class="col-md-12" style="margin-top: 34px">
                                                                    <i class="material-icons">
                                                                        cloud_upload
                                                                    </i>
                                                                    <p>Upload Multiple Images</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                    <div id="sortableImgThumbnailPreview" class="mt-5">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end mt-4">
                                            <ul>
                                                <li><button type="submit" class="primary-btn extra-btn-padding-30"
                                                        id="saveBtn">Save</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                </div>
            </div>
        </div>
        @include('Admin.Partials.script')
         <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#productForm').validate({ // initialize the plugin
                    rules: {
                        name: {
                            required: true
                        },
                        price: {
                            required: true,
                            digits: true
                        },
                        quantity: {
                            required: true,
                            digits: true

                        },
                        description: {
                            required: true,
                        },
                        main_img: {
                            required: true,
                            extension: "jpeg|png|jpg"
                        },
                    },
                    messages: {

                        name: {
                            required: "Please enter name",
                        },
                        price: {
                            required: "Please enter price",
                        },
                        quantity: {
                            required: "Please enter quantity",
                        },
                        description: {
                            required: "Please enter description",
                        },
                        main_img: {
                            required: "Please select image",
                        },
                    },
                });
            });
        </script>
        <script>
            $('#productForm').on('submit', function(e) {

                var name = $('#name').val()
                var price = $('#price').val()
                var quantity = $('#quantity').val()
                var description = $('#description').val()
                if (name != '' && price != '' && quantity != '' && description != '') {
 e.preventDefault()
                    $('#saveBtn').empty().append('Please Wait...');
                    $('#saveBtn').css({
                        'background': 'var(--black-btn-clr)',
                        'cursor': 'not-allowed'
                    })
                    $("#saveBtn").prop("disabled", true);
                    var formdata = new FormData(this)
                    $.ajax({
                        url: '{{ route('admin.product.store') }}',
                        type: 'POST',
                        data: formdata,
                        processData: false,
                        contentType: false,

                        success: function(res) {
                            swal(res.msg, {
                                icon: 'success'
                            })
                            $('#productForm')[0].reset();
                            $('#sortableImgThumbnailPreview').remove();
                            $('#saveBtn').empty().append('Save');
                            $('#saveBtn').css({
                                'background': 'var(--primary-clr)',
                                'cursor': 'pointer'
                            })
                            $("#saveBtn").prop("disabled", false);
                        }
                    })
                }
            })
        </script>
        <script>
            window.Promise ||
                document.write(
                    '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>'
                )
            window.Promise ||
                document.write(
                    '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>'
                )
            window.Promise ||
                document.write(
                    '<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
                )
        </script>

        <script>
            function readURL1(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#banner-img-upload1').attr('src', e.target.result);
                        $('#banner-img-upload1').css('display', 'block');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#file1").change(function() {
                readURL1(this);

            });
        </script>
        <script>
            $(function() {
                $("#sortableImgThumbnailPreview").sortable({
                    connectWith: ".RearangeBox",


                    start: function(event, ui) {
                        $(ui.item).addClass("dragElemThumbnail");
                        ui.placeholder.height(ui.item.height());

                    },
                    stop: function(event, ui) {
                        $(ui.item).removeClass("dragElemThumbnail");
                    }
                });
                $("#sortableImgThumbnailPreview").disableSelection();
            });


            document.getElementById('files').addEventListener('change', handleFileSelect, false);

            function handleFileSelect(evt) {

                var files = evt.target.files;
                var output = document.getElementById("sortableImgThumbnailPreview");

                // Loop through the FileList and render image files as thumbnails.
                for (var i = 0, f; f = files[i]; i++) {

                    // Only process image files.
                    if (!f.type.match('image.*')) {
                        continue;
                    }

                    var reader = new FileReader();

                    // Closure to capture the file information.
                    reader.onload = (function(theFile) {
                        return function(e) {
                            // Render thumbnail.
                            var imgThumbnailElem =
                                "<div class='RearangeBox imgThumbContainer'><i class='material-icons imgRemoveBtn' onclick='removeThumbnailIMG(this)'>close</i><div class='IMGthumbnail' ><img  src='" +
                                e.target.result + "'" + "title='" + theFile.name +
                                "'/></div><div class='imgName'>" + theFile.name + "</div></div>";

                            output.innerHTML = output.innerHTML + imgThumbnailElem;

                        };
                    })(f);

                    // Read in the image file as a data URL.
                    reader.readAsDataURL(f);
                }
            }

            function removeThumbnailIMG(elm) {
                elm.parentNode.outerHTML = '';
            }
        </script>
    @endsection
