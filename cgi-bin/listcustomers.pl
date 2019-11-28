#!/usr/bin/perl
use strict;
use warnings;
use CGI; 

my $compile = "/usr/bin/javac ListCustomers.java";
system($compile);

my $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom ListCustomers ";

print("Content-type: text/html\n\n");
print($cmd);
system($cmd);