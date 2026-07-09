<!-- user.php - School List -->
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper breadcrumb-contacts">
            <div>
                <h1>Registered Schools</h1>
                <p class="breadcrumbs">
                    <span><a href="#">Schools</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>All Schools
                </p>
            </div>
            <div>
                <a href="<?php echo base_url('admin/create_user'); ?>" class="btn btn-primary">
                    <i class="mdi mdi-plus"></i> Register New School
                </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="ec-cat-list card card-default">
                    <?php if(session()->getFlashdata('failed')): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <?= session()->getFlashdata('failed') ?>
                        </div>
                    <?php endif; ?>

                    <?php if(session()->getFlashdata('created')): ?>
                        <div class="alert alert-success alert-dismissable">
                            <?= session()->getFlashdata('created') ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <form id="news-filter">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Search School</label>
                                        <input type="text" class="form-control" id="search_date" placeholder="Search by school name or email...">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>City</label>
                                        <select class="form-control" id="city">
                                            <option value="">All Cities</option>
                                            <option value="Mumbai">Mumbai</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Bangalore">Bangalore</option>
                                            <option value="Chennai">Chennai</option>
                                            <option value="Hyderabad">Hyderabad</option>
                                            <option value="Kolkata">Kolkata</option>
                                            <option value="Pune">Pune</option>
                                            <option value="Ahmedabad">Ahmedabad</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" id="status">
                                            <option value="">All Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2" style="margin-top: 31px;">
                                    <div class="form-group">
                                        <button type="button" id="btn-filter-userlist" style="margin-right: 10px" class="btn btn-success search">Search</button>
                                        <button type="button" id="btn-reset-userlist" class="btn btn-danger reset">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-12 col-lg-12">
                <div class="ec-cat-list card card-default">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ajax_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#S.No</th>
                                        <th>School Details</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>City</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var table = $('#ajax_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url('admin/em_userlist'); ?>",
            "type": "POST",
            "data": function(data) {
                data.searchname = $('#search_date').val();
                data.status = $('#status').val();
                data.city = $('#city').val();
                data.id = '';
            }
        },
        "columns": <?= $table_column ?>,
        "pagingType": "simple_numbers_no_ellipses",
        "oLanguage": {
            "oPaginate": {
                "sFirst": "First",
                "sPrevious": "Previous",
                "sNext": "Next"
            }
        },
        "language": {
            "processing": '<div class="custom-spinner"></div>'
        },
        "initComplete": function() {
            $('#ajax_table').addClass('custom-datatable');
        },
        "bJQueryUI": false,
        "dom": '<"top"lB>frtip',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'btn btn-primary',
                title: 'schools_list_' + new Date().toLocaleDateString(),
            }
        ]
    });

    $('.search').on('click', function() {
        table.ajax.reload();
    });

    $('.reset').on('click', function() {
        $('#search_date').val('');
        $('#status').val('');
        $('#city').val('');
        table.ajax.reload();
    });
});
</script>