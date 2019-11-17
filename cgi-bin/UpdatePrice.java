import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;

public class UpdatePrice {
    public static void main(String[] args) throws SQLException{
        String user     = "C##benjamin.stafford";
        String password = "stafford6248";
        String database = "65.52.222.73:1521/cdb1";
        OracleDataSource ods = new OracleDataSource();
        ods.setURL("jdbc:oracle:thin:@" + database);
        ods.setUser(user);
        ods.setPassword(password);
        Connection conn = ods.getConnection();
        /*
            Args = {isbn-1, price-1, isbn-2, price-2, ... }*/
        try {
            Statement stmt = conn.createStatement();
            for(int i = 0; i < args.length; i += 2){
                stmt.executeUpdate("update book set book.price = " + args[i + 1] + " where book.isbn = " + args[i]);
            }
            stmt.close();
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        conn.close();
    }
}
