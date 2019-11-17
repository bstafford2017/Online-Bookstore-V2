#!/usr/bin/perl
use strict;
use warnings;

print("Content-type: text/html\n\n");

my $compile = "/usr/bin/javac ListBooks.java";
system($compile);

my $cmd = "/usr/bin/java -Djava.security.egd=file:/dev/./urandom ListBooks ";
system($cmd);