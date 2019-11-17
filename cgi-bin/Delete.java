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
            Statement newstmt = conn.createStatement();
            for(int i = 0; i < args.length; i++){
                ResultSet set = stmt.executeQuery("select subject.subject_name from book join subjects on subjects.isbn = book.isbn join subject on subject.subject_id = subjects.s_id where book.isbn = " + args[i].trim());
                while(set.next()){
                    String currentSubject = set.getString(1);
                    ResultSet getCount = newstmt.executeQuery("select count(*) from book join subjects on subjects.isbn = book.isbn join subject on subject.subject_id = subjects.s_id where subject.subject_name like '%" + currentSubject + "%'");
                    int count = 0;
                    while(getCount.next()){
                        count = Integer.parseInt(getCount.getString(1));
                    }
                    if(count == 1){
                        newstmt.executeUpdate("delete from subject where subject_name like '%" + currentSubject + "%'");
                    }
                }
                stmt.executeUpdate("delete from book where isbn = " + args[i].trim());
            }
            stmt.close();
        }
        catch (SQLException ex) {
            System.out.println(ex);
        }
        conn.close();
    }
}
