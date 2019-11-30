import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;
import java.util.Arrays;
import java.util.LinkedList;
import java.util.Iterator;
import java.util.Comparator;
import java.util.Collections;

public class Signup {
    public static void main(String[] args) throws SQLException {
        String user     = "C##benjamin.stafford";
        String password = "stafford6248";
        String database = "65.52.222.73:1521/cdb1";
        OracleDataSource ods = new OracleDataSource();
        ods.setURL("jdbc:oracle:thin:@" + database);
        ods.setUser(user);
        ods.setPassword(password);
        Connection conn = ods.getConnection();
        Statement stmt = conn.createStatement();
        try {
            stmt.executeUpdate("INSERT INTO customer (c_name, username, pwd, purchases, c_admin) VALUES ('" + args[0].trim() + "', '" + args[1].trim() + "', '" + args[2].trim() + "', NULL, " + args[3].trim() + ")");
            System.out.println("INSERT INTO customer (c_name, username, pwd, purchases, c_admin) VALUES ('" + args[0].trim() + "', '" + args[1].trim() + "', '" + args[2].trim() + "', NULL, " + args[3].trim() + ")");
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        stmt.close();
        conn.close();
    }
}
