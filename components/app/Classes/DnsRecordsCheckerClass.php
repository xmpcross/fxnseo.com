<?php 

namespace App\Classes;

class DnsRecordsCheckerClass {

    public function get_data($domain)
    {
        try {

            // Fetch all types of DNS records associated with the domain
            $dnsRecords = dns_get_record($domain, DNS_ALL);

            if (!$dnsRecords) {
                session()->flash('status', 'error');
                session()->flash('message', __('No DNS records found for the given domain.'));
                return [];
            }

            return $dnsRecords;
            
        } catch (\Exception $e) {

            session()->flash('status', 'error');
            session()->flash('message', __($e->getMessage()));
            return;
        }

    }

}