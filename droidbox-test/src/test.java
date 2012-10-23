import java.util.*;
import java.io.*;
import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.utils.URLEncodedUtils;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

public class test {
	private static String baseUrl = "http://localhost/db-wa/";
	private static String pageName_requestSong = "requestSong.php";
	private static String pageName_getLibrary = "getLibrary.php";
	public static void main(String[] args) throws Exception {
		List<NameValuePair> params = new ArrayList<NameValuePair>();
		for(int i = 1; i <= 5; ++i) {
			params.clear();
			params.add(new BasicNameValuePair("songID", (i + "")));			
			String ret = executePageRequest(pageName_requestSong, params);
			System.out.print(ret);
		}
	}
	
	private static String executePageRequest(String pageName, List<NameValuePair> params) {
		StringBuilder sb = new StringBuilder();
		DefaultHttpClient client = new DefaultHttpClient();
		HttpPost post = new HttpPost(baseUrl + pageName);
		try {
			post.setEntity(new UrlEncodedFormEntity(params));
			HttpResponse response = client.execute(post);
			HttpEntity entity = response.getEntity();
			InputStream is = entity.getContent();	
			BufferedReader reader = new BufferedReader(new InputStreamReader(is));
			String line = null;
			while((line = reader.readLine()) != null) {
				sb.append(line + "\n");
			}	
		}
		catch(Exception e) {
			sb.append(e.getMessage());
		}
		
		return sb.toString();
	}
}
