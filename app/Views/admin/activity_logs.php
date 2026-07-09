<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Activity Logs</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="<?= base_url('admin/export-logs') ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-file-export"></i> Export CSV
                    </a>
                    <button onclick="clearAllLogs()" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Clear All
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Filter Section -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filter Logs</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?= base_url('admin/activity-logs') ?>">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Search</label>
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Search by name, email, IP..." 
                                           value="<?= $search ?? '' ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Activity Type</label>
                                    <select name="activity_type" class="form-control">
                                        <option value="">All Types</option>
                                        <?php foreach($activity_types as $type): ?>
                                            <option value="<?= $type ?>" <?= ($activity_type ?? '') == $type ? 'selected' : '' ?>>
                                                <?= ucfirst($type) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <?php foreach($statuses as $s): ?>
                                            <option value="<?= $s ?>" <?= ($status ?? '') == $s ? 'selected' : '' ?>>
                                                <?= ucfirst($s) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Date From</label>
                                    <input type="date" name="date_from" class="form-control" 
                                           value="<?= $date_from ?? '' ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Date To</label>
                                    <input type="date" name="date_to" class="form-control" 
                                           value="<?= $date_to ?? '' ?>">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Logs Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Total Logs: <span class="badge badge-info"><?= $total_records ?? 0 ?></span>
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-success">Active</span>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Activity</th>
                                <th>Status</th>
                                <th>IP Address</th>
                                <th>Location</th>
                                <th>Device</th>
                                <th>Date/Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($logs)): ?>
                                <?php $counter = (($current_page ?? 1) - 1) * ($limit ?? 20) + 1; ?>
                                <?php foreach($logs as $log): ?>
                                    <tr>
                                        <td><?= $counter++ ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($log->user_name ?? 'Guest') ?></strong><br>
                                            <small class="text-muted"><?= htmlspecialchars($log->user_email ?? 'N/A') ?></small>
                                            <?php if($log->user_id): ?>
                                                <br><span class="badge badge-info">ID: <?= $log->user_id ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary"><?= ucfirst($log->activity_type) ?></span>
                                            <?php if($log->activity_details): ?>
                                                <br><small class="text-muted"><?= htmlspecialchars(substr($log->activity_details, 0, 50)) ?>...</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php 
                                            $statusClass = [
                                                'success' => 'success',
                                                'failed' => 'danger',
                                                'pending' => 'warning',
                                                'info' => 'info'
                                            ][$log->activity_status] ?? 'secondary';
                                            ?>
                                            <span class="badge badge-<?= $statusClass ?>">
                                                <?= ucfirst($log->activity_status) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($log->ip_address ?? 'N/A') ?>
                                            <?php if($log->country): ?>
                                                <br><small class="text-muted"><?= htmlspecialchars($log->country) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($log->city): ?>
                                                <?= htmlspecialchars($log->city) ?><br>
                                            <?php endif; ?>
                                            <?php if($log->location): ?>
                                                <small class="text-muted"><?= htmlspecialchars($log->location) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($log->browser): ?>
                                                <i class="fas fa-globe"></i> <?= htmlspecialchars($log->browser) ?><br>
                                            <?php endif; ?>
                                            <?php if($log->os): ?>
                                                <small class="text-muted"><?= htmlspecialchars($log->os) ?></small>
                                            <?php endif; ?>
                                            <?php if($log->device_type): ?>
                                                <br><span class="badge badge-secondary"><?= htmlspecialchars($log->device_type) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= date('d-m-Y H:i:s', strtotime($log->created_at)) ?>
                                            <br><small class="text-muted"><?= time_elapsed_string($log->created_at) ?></small>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/view-log-detail/' . $log->log_id) ?>" 
                                               class="btn btn-sm btn-info" title="View Details">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <button onclick="deleteLog(<?= $log->log_id ?>)" 
                                                    class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                        No activity logs found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if(($total_pages ?? 0) > 1): ?>
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <?php if(($current_page ?? 1) > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= ($current_page - 1) ?>&search=<?= $search ?? '' ?>&activity_type=<?= $activity_type ?? '' ?>&status=<?= $status ?? '' ?>&date_from=<?= $date_from ?? '' ?>&date_to=<?= $date_to ?? '' ?>">
                                    « Previous
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= ($i == ($current_page ?? 1)) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?? '' ?>&activity_type=<?= $activity_type ?? '' ?>&status=<?= $status ?? '' ?>&date_from=<?= $date_from ?? '' ?>&date_to=<?= $date_to ?? '' ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if(($current_page ?? 1) < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= ($current_page + 1) ?>&search=<?= $search ?? '' ?>&activity_type=<?= $activity_type ?? '' ?>&status=<?= $status ?? '' ?>&date_from=<?= $date_from ?? '' ?>&date_to=<?= $date_to ?? '' ?>">
                                    Next »
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<!-- Helper Function for Time Elapsed -->
<?php 
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>

<script>
// Delete single log
function deleteLog(logId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= base_url("admin/delete-log") ?>/' + logId;
        }
    });
}

// Clear all logs
function clearAllLogs() {
    Swal.fire({
        title: 'Are you sure?',
        text: "All logs will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, clear all!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= base_url("admin/clear-all-logs") ?>';
        }
    });
}

// Auto-refresh logs every 30 seconds (optional)
// setInterval(function() {
//     location.reload();
// }, 30000);
</script>

<style>
.table td {
    vertical-align: middle !important;
}
.badge {
    font-size: 12px;
}
.card-header .badge {
    font-size: 14px;
    padding: 5px 10px;
}
</style>