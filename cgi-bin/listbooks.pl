#!/usr/bin/perl
use strict;
use warnings;
use CGI;
my $query = new CGI;
my $flag = $query->param('flag');

print("Content-type: text/html\n\n");

my $compile = "/usr/bin/javac ListBooks.java";
system($compile);

my $cmd = "";
if(!defined $flag){
    $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom ListBooks ";
} else {
    $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom ListBooks " . $flag;
}
system($cmd);