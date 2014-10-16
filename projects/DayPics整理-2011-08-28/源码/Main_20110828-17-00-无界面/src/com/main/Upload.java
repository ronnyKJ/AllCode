package com.main;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.FileInputStream;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

import android.app.Activity;
import android.content.ContentResolver;
import android.content.Intent;
import android.database.Cursor;
import android.net.Uri;
import android.os.Bundle;
import android.util.Log;
import android.widget.EditText;
import android.widget.Toast;
import biz.source_code.base64Coder.Base64Coder;

public class Upload extends Activity {
	public static void upload(Uri uri, String action, Activity act)
    {
      String end = "\r\n";
      String twoHyphens = "--";
      String boundary = "*****";
      try
      {
        URL url = new URL(action);
        HttpURLConnection con = (HttpURLConnection) url.openConnection();
        /* 允许Input、Output，不使用Cache */
        con.setDoInput(true);
        con.setDoOutput(true);
        con.setUseCaches(false);
        /* 设定传送的method=POST */
        con.setRequestMethod("POST");
        /* setRequestProperty */
        con.setRequestProperty("Connection", "Keep-Alive");
        con.setRequestProperty("Charset", "UTF-8");
        con.setRequestProperty("Content-Type", "application/x-www-form-urlencoded;boundary=" + boundary);
        /* 设定DataOutputStream */
        DataOutputStream ds = new DataOutputStream(con.getOutputStream());
                
        //把留言加在文件头部，用b@_@b分割
        EditText et = (EditText)act.findViewById(R.id.words);
        String words = Base64Coder.encodeString(et.getText().toString());
        ds.writeBytes(words + "b@_@b");
        
        /* 取得文件的FileInputStream */
       	ContentResolver cr = act.getContentResolver();
    	Cursor cursor = cr.query(uri, null, null, null, null);
    	cursor.moveToFirst();
    	String uploadFile = cursor.getString(1);
        FileInputStream fStream = new FileInputStream(uploadFile);
        /* 设定每次写入1024bytes */
        int bufferSize = 1024;
        byte[] buffer = new byte[bufferSize];

        int length = -1;
        /* 从文件读取数据到缓冲区 */
        while ((length = fStream.read(buffer)) != -1)
        {
          /* 将数据写入DataOutputStream中 */
          ds.write(buffer, 0, length);
        }
        ds.writeBytes(end);
        ds.writeBytes(twoHyphens + boundary + twoHyphens + end);

        /* close streams */
        fStream.close();
        ds.flush();

        /* 取得Response内容 */
        InputStream is = con.getInputStream();
        StringBuffer b = new StringBuffer();
        BufferedReader br = new BufferedReader(  
                new InputStreamReader(is,"UTF-8"));  
        String data = "";  

        while ((data = br.readLine()) != null) {  
            b.append(data); 
        }
        /* 将Response显示于Dialog */
        //showDialog(b.toString().trim());
        Toast.makeText(act.getApplicationContext(), b.toString().trim(), Toast.LENGTH_LONG).show();
        /* 关闭DataOutputStream */
        ds.close();   
      }
      catch (Exception e)
      {
    	  Log.e("Exception", e.toString());
      }
    }
}
