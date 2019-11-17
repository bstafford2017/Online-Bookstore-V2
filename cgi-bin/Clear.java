import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;
import java.util.Arrays;
import java.util.stream.Stream;

public class Clear {
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
            Statement stmt = conn.createStatement();
            stmt.executeUpdate("delete from subjects");
            stmt.executeUpdate("delete from subject");
            stmt.executeUpdate("delete from book");
            System.out.println("Content-type: text/html\n\n");
            stmt.close();
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        conn.close( );
    }
}
