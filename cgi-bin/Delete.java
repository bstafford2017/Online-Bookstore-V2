import java.sql.*;
import java.util.LinkedList;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;
import java.util.*;

public class Delete {
    public static void main(String[] args) throws SQLException{
        String user     = "C##benjamin.stafford";
        String password = "stafford6248";
        String database = "65.52.222.73:1521/cdb1";
        OracleDataSource ods = new OracleDataSource();
        ods.setURL("jdbc:oracle:thin:@" + database);
        ods.setUser(user);
        ods.setPassword(password);
        Connection conn = ods.getConnection();
        try {
            // Get list of all subject's in isbn record
            Statement stmt = conn.createStatement();
            for(int i = 0; i < args.length; i++){
                stmt.executeUpdate("DELETE FROM book WHERE isbn = " + args[i].trim());
                System.out.println("\nDELETE FROM book WHERE isbn = " + args[i].trim());
            }
            stmt.close();
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        conn.close();
    }
}
