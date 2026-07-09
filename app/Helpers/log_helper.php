<?php

if (!function_exists('logActivity')) {
    /**
     * Log user activity
     * 
     * @param array $data Log data
     * @return bool
     */
   

    function logActivity($data = [])
    {
        try {
            $db = \Config\Database::connect();
            
            // Get IP address
            $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            
            // Get user agent
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
            
            // Prepare log data
            $logData = [
                'user_id' => $data['user_id'] ?? null,
                'user_email' => $data['user_email'] ?? null,
                'user_name' => $data['user_name'] ?? null,
                'activity_type' => $data['activity_type'] ?? 'registration',
                'activity_status' => $data['activity_status'] ?? 'success',
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'activity_details' => $data['details'] ?? null,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            // Insert log
            $builder = $db->table('activity_logs');
            return $builder->insert($logData);
            
        } catch (\Exception $e) {
            log_message('error', 'Activity Log Error: ' . $e->getMessage());
            return false;
        }
    }

}

if (!function_exists('get_ip_address')) {
    /**
     * Get real IP address
     */
    function get_ip_address()
    {
        $ipKeys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];
        
        foreach ($ipKeys as $key) {
            if (isset($_SERVER[$key]) && filter_var($_SERVER[$key], FILTER_VALIDATE_IP)) {
                return $_SERVER[$key];
            }
        }
        
        return '0.0.0.0';
    }
}

if (!function_exists('get_browser_info')) {
    /**
     * Get browser and OS information
     */
    function get_browser_info($userAgent)
    {
        $browser = 'Unknown';
        $os = 'Unknown';
        $deviceType = 'Desktop';
        
        // Detect Browser
        if (strpos($userAgent, 'Chrome') !== false) {
            $browser = 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            $browser = 'Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            $browser = 'Safari';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            $browser = 'Edge';
        } elseif (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) {
            $browser = 'Opera';
        } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
            $browser = 'Internet Explorer';
        }
        
        // Detect OS
        if (strpos($userAgent, 'Windows') !== false) {
            $os = 'Windows';
        } elseif (strpos($userAgent, 'Macintosh') !== false) {
            $os = 'macOS';
        } elseif (strpos($userAgent, 'Linux') !== false) {
            $os = 'Linux';
        } elseif (strpos($userAgent, 'Android') !== false) {
            $os = 'Android';
        } elseif (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
            $os = 'iOS';
        }
        
        // Detect Device Type
        if (strpos($userAgent, 'Mobile') !== false || strpos($userAgent, 'Android') !== false) {
            $deviceType = 'Mobile';
        } elseif (strpos($userAgent, 'Tablet') !== false || strpos($userAgent, 'iPad') !== false) {
            $deviceType = 'Tablet';
        }
        
        return [
            'browser' => $browser,
            'os' => $os,
            'device_type' => $deviceType
        ];
    }
}

if (!function_exists('get_geo_location')) {
    /**
     * Get geo location from IP address
     */
    function get_geo_location($ip)
    {
        try {
            // Skip for local IPs
            if (in_array($ip, ['127.0.0.1', '::1', '0.0.0.0'])) {
                return null;
            }
            
            // Use ip-api.com for geo location
            $url = "http://ip-api.com/json/{$ip}?fields=status,country,city,lat,lon";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            $response = curl_exec($ch);
            curl_close($ch);
            
            if ($response) {
                $data = json_decode($response, true);
                if ($data && $data['status'] == 'success') {
                    return [
                        'country' => $data['country'] ?? null,
                        'city' => $data['city'] ?? null,
                        'location' => ($data['city'] ?? '') . ', ' . ($data['country'] ?? ''),
                        'latitude' => $data['lat'] ?? null,
                        'longitude' => $data['lon'] ?? null
                    ];
                }
            }
        } catch (\Exception $e) {
            // Silent fail
        }
        
        return null;
    }
}