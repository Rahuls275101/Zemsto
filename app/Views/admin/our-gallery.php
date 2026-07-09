<div class="ec-content-wrapper">
    <div class="content">
        <!-- Breadcrumb -->
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>All Gallery / Signature Talks</h1>
                <p class="breadcrumbs">
                    <span><a href="#">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span> All Gallery / Signature Talks
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('failed')): ?>
                    <div class="alert alert-danger alert-dismissable">
                        <?= session()->getFlashdata('failed') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('created')): ?>
                    <div class="alert alert-success alert-dismissable">
                        <?= session()->getFlashdata('created') ?>
                    </div>
                <?php endif; ?>

                <!-- Upload Card -->
                <div class="card">
                    <div class="card-body">
                        <form class="form-inline" method="POST" action="<?= base_url('admin/our_gallery_process'); ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Name*</label>
                                        <input type="text" class="form-control" required name="name">
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Type*</label>
                                        <select class="form-control" required name="type">
                                            <option value="Olympiads">Olympiads</option>
                                            <option value="Activities">Activities</option>
                                             <option value="Winners">Winners</option>
                                              <option value="Hall of Fame">Hall of Fame</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image*</label>
                                        <input type="file" class="form-control" required name="client_logo">
                                    </div>
                                </div>

                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" name="upload_logo" class="btn btn-success">Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="table-responsive">
                        
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#S.No</th>
                                    <th>Name</th>
                                    <th>URL</th>
                                    <th>Type</th>
                                    <th>Gallery</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $clientSeId = 1;
                                foreach ($clientView as $client) :
                                ?>
                                    <tr>
                                        <td><?= $clientSeId++; ?></td>
                                        <td><?= $client->name; ?></td>
                                        <td><?= $client->location; ?></td>
                                        <td><?= $client->type; ?></td>
                                        <td>
                                            <img src="<?=  base_url('assets/client/' . $client->client_image); ?>" style="width: 200px; height: 100px;">
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/delete_gallery/' . $client->client_id); ?>" class="btn btn-danger btn-sm">Delete</a>
                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm editBtn" data-id="<?= $client->client_id; ?>">Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editGalleryModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Project</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editGalleryForm" enctype="multipart/form-data">
                                    <input type="hidden" name="client_id" id="client_id">

                                    <div class="mb-3">
                                        <label>Name*</label>
                                        <input type="text" class="form-control" name="name" id="name" required>
                                    </div>

                                 

                                    <div class="mb-3">
                                        <label>Type*</label>
                                        <select class="form-control" name="type" id="type" required>
                                                 <option value="Olympiads">Olympiads</option>
                                            <option value="Activities">Activities</option>
                                             <option value="Winners">Winners</option>
                                              <option value="Hall of Fame">Hall of Fame</option>
                                        </select>
                                    </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image*</label>
                                        <input type="file" class="form-control" required name="client_logo">
                                    </div>
                                </div>
                             

                                    <button type="submit" class="btn btn-success">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- JavaScript for Modal & AJAX -->
                <script>
                    $(document).ready(function () {
                        const base_url = '<?= base_url(); ?>';

                        // Edit button click handler
                        $(".editBtn").click(function () {
                            const id = $(this).data("id");

                            $.ajax({
                                url: base_url + "/admin/edit_gallery/" + id,
                                type: "GET",
                                dataType: "json",
                                success: function (res) {
                                    if (res.status) {
                                        $("#client_id").val(res.data.client_id);
                                        $("#name").val(res.data.name);
                                        $("#type").val(res.data.type);

                                        // Show preview if image exists
                                        if (res.data.client_image) {
                                            $("#previewImg").html(
                                                `<img src="${base_url}assets/client/${res.data.client_image}" style="width:150px;">`
                                            );
                                        } else {
                                            $("#previewImg").html("");
                                        }

                                        $("#editGalleryModal").modal("show");
                                    } else {
                                        alert("Data not found.");
                                    }
                                },
                                error: function () {
                                    alert("Error fetching data.");
                                }
                            });
                        });

                        // Submit updated data
                        $("#editGalleryForm").submit(function (e) {
                            e.preventDefault();

                            const formData = new FormData(this);

                            $.ajax({
                                url: base_url + "/admin/our_gallery_update",
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                dataType: "json",
                                success: function (res) {
                                    if (res.status) {
                                        alert(res.message);
                                        location.reload();
                                    } else {
                                        alert(res.message);
                                    }
                                },
                                error: function () {
                                    alert("Update failed.");
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
