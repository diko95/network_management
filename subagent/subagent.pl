#!/usr/bin/perl

use NetSNMP::agent (':all');
use NetSNMP::ASN ;

sub helloa1 {
  my ($handler, $registration_info, $request_info, $requests) = @_;
  my $request;
  for($request = $requests; $request; $request = $request->next()) {
      my $oid = $request->getOID();
      if ($request_info->getMode() == MODE_GET) {
        if ($oid == new NetSNMP::OID(".1.3.6.1.4.1.4171.40.1")) {
            $request->setValue(ASN_COUNTER, time());
           }
        elsif ($oid > new NetSNMP::OID(".1.3.6.1.4.1.4171.40.1")) {
            my $oid1 = "$oid";
            my @t = split(/[.]/, $oid1);
            open(FILE, "/home/diko/counters.conf");
            my %hash;
            while ( <FILE>)
            {
               my ($key, $val) = split/,/;
               $hash{$key} = $val;
               $x = int($t[-1]);
               if($hash{$x-1}){
                  $c = $hash{$x-1};
                  $c=int($c);
                  $y = $c*time;

                  }
               
            }
                        
            $request->setValue(ASN_COUNTER, $y);

            
        }
        
        
      }
   }
   
}

my $agent = new NetSNMP::agent();
$agent->register("helloa1", ".1.3.6.1.4.1.4171.40",
                         \&helloa1);

