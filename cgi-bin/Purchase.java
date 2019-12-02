import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;
import java.util.Arrays;
import java.util.LinkedList;
import java.util.Iterator;
import java.util.Comparator;
import java.util.Collections;

public class Purchase {
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
            /*
                args[] = {username, isbn0, isbn1, ... }
            */
            String query = "INSERT INTO table(SELECT purchases FROM customer WHERE username LIKE '" + args[0].trim() + "') VALUES (";
            for(int i = 1; i < args.length; i++){
                if(i == args.length - 1){
                    query += args[i].trim();
                } else {
                    query = query + args[i].trim() + ", ";
                }
            }
            query += ")";
            System.out.println("\n" + query);
            stmt.executeUpdate(query);
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        stmt.close();
        conn.close();
    }
}
