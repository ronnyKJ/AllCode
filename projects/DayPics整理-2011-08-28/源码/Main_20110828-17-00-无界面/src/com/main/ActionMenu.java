package com.main;

import android.app.Activity;
import android.view.Menu;
import android.view.MenuItem;
import android.webkit.WebView;
import android.widget.Toast;

public class ActionMenu extends Activity {
	public static void setMenuItemWebApp(Menu menu) {
		/*
		 * add()方法的四个参数，依次是：
		 * 1、组别，如果不分组的话就写Menu.NONE,
		 * 2、Id，这个很重要，Android根据这个Id来确定不同的菜单
		 * 3、顺序，那个菜单现在在前面由这个参数的大小决定
		 * 4、文本，菜单的显示文本
		 */
		menu.add(Menu.NONE, Menu.FIRST + 1, 3, "主菜单").setIcon(android.R.drawable.ic_menu_delete);
		// setIcon()方法为菜单设置图标，这里使用的是系统自带的图标，同学们留意一下,以
		// android.R开头的资源是系统提供的，我们自己提供的资源是以R开头的
		menu.add(Menu.NONE, Menu.FIRST + 2, 4, "设置").setIcon(android.R.drawable.ic_menu_set_as);
		menu.add(Menu.NONE, Menu.FIRST + 3, 5, "退出程序").setIcon(android.R.drawable.ic_menu_edit);
		menu.add(Menu.FIRST, Menu.FIRST + 4, 1, "刷新").setIcon(android.R.drawable.ic_menu_delete);
		menu.add(Menu.FIRST, Menu.FIRST + 5, 2, "后退").setIcon(android.R.drawable.ic_menu_delete);
	}

	public static int selectItem(MenuItem item) {
		switch (item.getItemId()) {
		case Menu.FIRST + 1:
			return 1;
		case Menu.FIRST + 2:
			return 2;
		case Menu.FIRST + 3:
			return 3;
		case Menu.FIRST + 4:
			return 4;
		case Menu.FIRST + 5:
			return 5;
		}
		return 0;
	}
	
	public static void setMenuItem(Menu menu) {
		menu.add(Menu.NONE, Menu.FIRST + 1, 1, "主菜单").setIcon(android.R.drawable.ic_menu_delete);
		menu.add(Menu.NONE, Menu.FIRST + 2, 2, "设置").setIcon(android.R.drawable.ic_menu_set_as);
		menu.add(Menu.NONE, Menu.FIRST + 3, 3, "退出程序").setIcon(android.R.drawable.ic_menu_edit);
	}
}
