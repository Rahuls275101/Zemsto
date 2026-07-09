<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Log Details</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="<?= base_url('admin/activity-logs') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Logs
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">User Information</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="150">Log ID</th>
                                    <td>#<?= $log->log_id ?></td>
                                </tr>
                                <tr>
                                    <th>User Name</th>
                                    <td><?= htmlspecialchars($log->user_name ?? 'Guest') ?></td>
                                </tr>
                                <tr>
                                    <th>User Email</th>
                                    <td><?= htmlspecialchars($log->user_email ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>User ID</th>
                                    <td><?= $log->user_id ?? 'N/A' ?></td>
                                </tr>
                                <tr>
                                    <th>Activity Type</th>
                                    <td><span class="badge badge-primary"><?= ucfirst($log->activity_type) ?></span></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
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
                                </tr>
                                <tr>
                                    <th>Details</th>
                                    <td><?= nl2br(htmlspecialchars($log->activity_details ?? 'N/A')) ?></td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td><?= date('d-m-Y H:i:s', strtotime($log->created_at)) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Location & Device Information</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="150">IP Address</th>
                                    <td><?= htmlspecialchars($log->ip_address ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td><?= htmlspecialchars($log->country ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td><?= htmlspecialchars($log->city ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td><?= htmlspecialchars($log->location ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Latitude</th>
                                    <td><?= htmlspecialchars($log->latitude ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Longitude</th>
                                    <td><?= htmlspecialchars($log->longitude ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Browser</th>
                                    <td><?= htmlspecialchars($log->browser ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Operating System</th>
                                    <td><?= htmlspecialchars($log->os ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Device Type</th>
                                    <td><span class="badge badge-secondary"><?= htmlspecialchars($log->device_type ?? 'N/A') ?></span></td>
                                </tr>
                                <tr>
                                    <th>Session ID</th>
                                    <td><small><?= htmlspecialchars($log->session_id ?? 'N/A') ?></small></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Request Information</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="150">Page URL</th>
                                    <td><a href="<?= htmlspecialchars($log->page_url ?? '#') ?>" target="_blank"><?= htmlspecialchars($log->page_url ?? 'N/A') ?></a></td>
                                </tr>
                                <tr>
                                    <th>Referrer URL</th>
                                    <td><?= htmlspecialchars($log->referrer_url ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th>Request Method</th>
                                    <td><span class="badge badge-warning"><?= htmlspecialchars($log->request_method ?? 'N/A') ?></span></td>
                                </tr>
                                <tr>
                                    <th>User Agent</th>
                                    <td><small><?= htmlspecialchars($log->user_agent ?? 'N/A') ?></small></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>