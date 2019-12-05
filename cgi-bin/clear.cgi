#!/usr/bin/bash
# To set up the Oracle environment dynamically
CLASSPATH=.:/usr/lib/oracle/12.1/client64
CLASSPATH=$CLASSPATH:/usr/lib/oracle/12.1/client64/lib/ojdbc7.jar
CLASSPATH=$CLASSPATH:/usr/lib/oracle/12.1/client64/lib/ottclasses.zip
export CLASSPATH

/usr/bin/javac Clear.java
/usr/bin/java -Djava.security.egd=file:/dev/./urandom Clear