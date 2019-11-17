import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;

public class Hyperlink2 {
    public static void main(String[] args) throws SQLException {
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
            String query = "select id from customer c where c.username = '" + args[0].trim() + "' and c.password = '" + args[1].trim() + "'";
            ResultSet rset = stmt.executeQuery(query);
            int counter = 0;
            while(rset.next()){
                System.out.println(rset.getString(1) + " ");
            }
            if(counter == 0){
                System.out.println("Error");
            }
            rset.close();
            stmt.close();
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        conn.close();
    }
}
