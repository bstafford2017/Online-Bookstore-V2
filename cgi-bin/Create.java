import java.sql.*;
import java.io.*;
import oracle.jdbc.*;
import oracle.jdbc.pool.OracleDataSource;
import java.util.Arrays;
import java.util.stream.Stream;

public class Create {
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
            /* Each have a value
               Assumed order is: {isbn, title, price, subject1, subject2, ...} */
            
            // Insert into books table
            args[1] = args[1].replaceAll("-", " ");
            for(int i = 3; i < args.length; i++){
                args[i] = args[i].replaceAll("-", " ");
            }
            String insertBook = "insert into book(isbn, title, price) values (" + args[0] + ", '" + args[1] + "', " + args[2] + ")";
            stmt.executeQuery(insertBook);

            // Loop through all subjects
            for(int i = 3; i < args.length; i++){
                String getSubjectId = "select subject_id from subject where subject_name = '" + args[i] + "'";
                ResultSet rset = stmt.executeQuery(getSubjectId);
                // If subject is already in table
                if(rset.next()){
                    // Only needs to be inserted into subjects (joining table)
                    String subjectId = rset.getString(1);
                    String insertSubjects = "insert into subjects(isbn, s_id) values (" + args[0] + ", " + subjectId + ")";
                    stmt.executeQuery(insertSubjects);
                } else {
                    // Insert into subject (stores names)
                    String insertSubject = "insert into subject(subject_name) values ('" + args[i] + "')";
                    stmt.executeQuery(insertSubject);
                    // Get subject ID of new insert
                    String getNewId = "select subject_id from subject where subject_name = '" + args[i] + "'";
                    ResultSet newSet = stmt.executeQuery(getNewId);
                    if(newSet.next()){
                        // Insert into subjects (joining table)
                        String insertSubjects = "insert into subjects(isbn, s_id) values (" + args[0] + ", " + newSet.getString(1) + ")";
                        stmt.executeQuery(insertSubjects);
                    }
                    newSet.close();
                }
                rset.close();
            }
            stmt.close();
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        conn.close();
    }
}
