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
            //String query = "{call insertPurchases(?, purchase_table(";
            String query = "BEGIN insertPurchases('" + args[0].trim() + "', purchase_table(";
            for(int i = 1; i < args.length; i++){
                if(i == args.length - 1){
                    //query += args[i].trim() + "))}";
                    query += args[i].trim() + ")); END;";
                } else {
                    query += args[i].trim() + ", ";
                }
            }
            CallableStatement cstmt = conn.prepareCall(query);
            //cstmt.setString(1, args[0].trim());
            /*String query = "{call insertPurchases(?, purchase_table(";
            for(int i = 1; i < args.length; i++){
                if(i == args.length - 1){
                    query += "?))}";
                } else {
                    query += "?, ";
                }
            }
            CallableStatement cstmt = conn.prepareCall(query);
            cstmt.setString(1, args[0].trim());
            for(int i = 1; i < args.length; i++){
                cstmt.setLong((i + 1), Long.parseLong(args[i].trim()));
            }*/
            System.out.println(query);
            cstmt.executeUpdate();
            cstmt.close();
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        stmt.close();
        conn.close();
    }
}
