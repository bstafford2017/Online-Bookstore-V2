#!/usr/bin/perl
use strict;
use warnings;
use CGI;
my $query = new CGI;
my $username = $query->param('username');

my $compile = "/usr/bin/javac ListCustomers.java";
system($compile);

my $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom ListCustomers";

if(defined $username){
    $cmd = $cmd . " " . $username;
}

print("Content-type: text/html\n\n");
print($cmd);
system($cmd);