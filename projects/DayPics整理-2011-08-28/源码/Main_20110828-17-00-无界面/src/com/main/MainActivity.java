package com.main;

import java.io.FileInputStream;
import java.io.FileNotFoundException;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.ContentResolver;
import android.content.ContentValues;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.hardware.Camera;
import android.hardware.Camera.PictureCallback;
import android.hardware.Camera.ShutterCallback;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Log;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.Toast;

public class MainActivity extends Activity {
	private ImageButton webBtn;
	private ImageButton photoBtn;
	private ImageButton galleryBtn;
	private WebView webView;
	private String phoneUrl;
	private String uploadUrl;
	private Intent tmpIntent;
	private Uri tmpUri;

	/** Called when the activity is first created. */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		//检查网络连接
		ConnectivityManager conManager = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
		NetworkInfo networkInfo = conManager.getActiveNetworkInfo();    
		if (networkInfo == null || !conManager.getBackgroundDataSetting()) {
			Toast.makeText(getApplicationContext(), "无网络连接，强制退出程序，不好意思...", Toast.LENGTH_LONG).show();
			finish();
			//System.exit(0);
			return;      
		 } 

		//初始化URL
		uploadUrl = getString(R.string.domain_name) + getString(R.string.upload_action);
		phoneUrl = getString(R.string.domain_name) + getString(R.string.phone_action);
		// 将图片uri转化为路径
		Intent intent = getIntent();
		Bundle extras = intent.getExtras();
		String action = intent.getAction();

		// if this is from the share menu
		if (Intent.ACTION_SEND.equals(action)) {
			setContentView(R.layout.photo);
			if (extras.containsKey(Intent.EXTRA_STREAM)) {
				// Get resource path from intent callee
				tmpUri = (Uri) extras.getParcelable(Intent.EXTRA_STREAM);
				ContentResolver cr = this.getContentResolver();
				Cursor cursor = cr.query(tmpUri, null, null, null, null);
				cursor.moveToFirst();
				String uploadFile = cursor.getString(1);

				if (!uploadFile.equals("")) {
					// 在界面显示图片
					ImageView myImg = (ImageView) findViewById(R.id.myImage);
					Bitmap bitmap = getLoacalBitmap(uploadFile); // 从本地取图片
					myImg.setImageBitmap(bitmap);
					/* 设定mButton的onClick事件处理 */
					Button mButton = (Button) findViewById(R.id.upload);
					mButton.setOnClickListener(new View.OnClickListener() {
						public void onClick(View v) {
							Upload.upload(tmpUri, uploadUrl, MainActivity.this);
							setContentView(R.layout.main);
							// 主菜单按钮事件绑定
							bindImgBtnAction();
						}
					});
				}
			} else if (extras.containsKey(Intent.EXTRA_TEXT)) {
				return;
			}
		} else {
			setContentView(R.layout.main);
			// 主菜单按钮事件绑定
			bindImgBtnAction();
		}
	}

	// 显示本地图片
	public Bitmap getLoacalBitmap(String url) {
		try {
			FileInputStream fis = new FileInputStream(url);
			return BitmapFactory.decodeStream(fis);
		} catch (FileNotFoundException e) {
			e.printStackTrace();
			return null;
		}
	}

	// 主菜单按钮事件绑定
	public void bindImgBtnAction() {
		/* 设定WebBtn的onClick事件处理 */
		webBtn = (ImageButton) findViewById(R.id.WebBtn);
		webBtn.setOnClickListener(new View.OnClickListener() {
			public void onClick(View v) {
				setContentView(R.layout.web);
				webView = (WebView) findViewById(R.id.webView);
				webView.getSettings().setJavaScriptEnabled(true);

				webView.setWebViewClient(new WebViewClient() {
					// 重写此方法表明点击网页里面的链接还是在当前的webview里跳转，不跳到浏览器那边
					@Override
					public boolean shouldOverrideUrlLoading(WebView view,
							String url) {
						view.loadUrl(url);
						return true;
					}

					// @Override
					// public void onReceivedSslError(WebView view,
					// SslErrorHandler handler,
					// android.net.http.SslError error) { //
					// 重写此方法可以让webview处理https请求
					// handler.proceed();
					// }
				});
				webView.setWebChromeClient(new WebChromeClient() {
					// 这里是设置activity的标题
					@Override
					public void onProgressChanged(WebView view, int newProgress) {
						setTitle("DayPics - " + newProgress + "%");
					}
				});

				webView.loadUrl(phoneUrl);
			}
		});
		
		/* 设定photoBtn的onClick事件处理 */
		photoBtn = (ImageButton) findViewById(R.id.PhotoBtn);
		photoBtn.setOnClickListener(new View.OnClickListener() {
			public void onClick(View v) {
				setContentView(R.layout.photo);
				takePhoto();
			}
		});

		/* 设定galleryBtn的onClick事件处理 */
		galleryBtn = (ImageButton) findViewById(R.id.GalleryBtn);
		galleryBtn.setOnClickListener(new View.OnClickListener() {
			public void onClick(View v) {
				setContentView(R.layout.photo);
				openGallery();
			}
		});
	}
	
	//启动照相机
	public void takePhoto() {
		Log.d("ANDRO_CAMERA", "Starting camera on the phone...");
		String fileName = "testphoto.jpg";
		ContentValues values = new ContentValues();
		values.put(MediaStore.Images.Media.TITLE, fileName);
		values.put(MediaStore.Images.Media.DESCRIPTION,
				"Image capture by camera");
		values.put(MediaStore.Images.Media.MIME_TYPE, "image/jpeg");
		tmpUri = getContentResolver().insert(
				MediaStore.Images.Media.EXTERNAL_CONTENT_URI, values);
		Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
		intent.putExtra(MediaStore.EXTRA_OUTPUT, tmpUri);
		intent.putExtra(MediaStore.EXTRA_VIDEO_QUALITY, 1);
		startActivityForResult(intent, 2);
	}

	//打开媒体库
	private void openGallery() {
		Intent intent = new Intent();
		/* Open the page of select pictures and set the type to image */
		intent.setType("image/*");
		intent.setAction(Intent.ACTION_GET_CONTENT);
		startActivityForResult(intent, 1);
	}
	
	
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		//响应媒体库照片选择
		if (resultCode == RESULT_OK && requestCode == 1) {
			tmpIntent = data;
			tmpUri = tmpIntent.getData();
			Log.e("uri", tmpUri.toString());
			ContentResolver cr = this.getContentResolver();
			try {
				Bitmap bitmap = BitmapFactory.decodeStream(cr
						.openInputStream(tmpUri));
				ImageView imageView = (ImageView) findViewById(R.id.myImage);
				/* 将Bitmap设定到ImageView */
				imageView.setImageBitmap(bitmap);
				photoUpload();
			} catch (FileNotFoundException e) {
				Log.e("Exception", e.getMessage(), e);
			}
		}
		super.onActivityResult(requestCode, resultCode, data);
		
		//响应拍照动作
		if (requestCode == 2 && resultCode == RESULT_OK) {
			ImageView imageView = (ImageView) findViewById(R.id.myImage);
			imageView.setImageURI(tmpUri);
			photoUpload();
		}
	}
	
	//绑定按钮上传图片
	public void photoUpload()
	{
		/* 设定mButton的onClick事件处理 */
		Button mButton = (Button) findViewById(R.id.upload);
		mButton.setOnClickListener(new View.OnClickListener() {
			public void onClick(View v) {
				Upload.upload(tmpUri, uploadUrl, MainActivity.this);
				setContentView(R.layout.main);
				bindImgBtnAction();
			}
		});		
	}
		
	//后退键处理
	@Override
	public void onBackPressed() {
		//在webView则成为网页后退键
		if (findViewById(R.id.webView) != null && webView.canGoBack()) {
			webView.goBack(); // goBack()表示返回webView的上一页面
			return;
		}
		//在主界面退出程序
		if (findViewById(R.id.GalleryBtn) != null) {
			quit();
			return;
		}
		
		//在上传页面退回主界面
		if (findViewById(R.id.upload) != null) {
			setContentView(R.layout.main);
			bindImgBtnAction();			
		}
		return;
	}
	
	//退出程序
	public void quit()
	{
		new AlertDialog.Builder(this)
		.setTitle("DayPics")
		.setMessage("确定退出?")
		.setIcon(android.R.drawable.ic_dialog_info)
		.setPositiveButton("确定",
				new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog,
							int whichButton) {
						setResult(RESULT_OK);// 确定按钮事件
						System.exit(0);
					}
				})
		.setNegativeButton("取消",
				new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog,
							int whichButton) {
						// 取消按钮事件
					}
				}).show();		
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		int i = ActionMenu.selectItem(item);
		switch (i) {
		case 1:
			setContentView(R.layout.main);
			bindImgBtnAction();
			break;
		case 2:
			break;
		case 3:
			quit();
			break;
		case 4:
			webView.reload();
			break;
		case 5:
			webView.goBack();
			break;
		}
		return false;
	}
	
	
	@Override
	public boolean onPrepareOptionsMenu(Menu menu) {
		menu.clear();
		if(findViewById(R.id.webView)!=null)
		{
			ActionMenu.setMenuItemWebApp(menu);
		}
		else
		{
			ActionMenu.setMenuItem(menu);
		}
		// 如果返回false，此方法就把用户点击menu的动作给消费了，onCreateOptionsMenu方法将不会被调用
		return true;
	}
}