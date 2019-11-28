import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;

public class Login {
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
            String query = "SELECT c_id FROM customer WHERE lower(username) LIKE '" + args[0].trim().toLowerCase() + "' AND lower(pwd) LIKE '" + args[1].trim().toLowerCase() + "'";
            ResultSet rset = stmt.executeQuery(query);
            int counter = 0;
            while(rset.next()){
                System.out.println(rset.getString(1) + " ");
                counter++;
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
