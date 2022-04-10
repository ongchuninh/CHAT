<h1>Docs CMS Laravel Sai Gon</h1>
<h3>1.Migrate & Seeds</h3>
	<p>1.1. Migrate</p>
	<ul>
		<li>Thư mục nằm tại (../database/migrations), có tác dụng quản lý củng như lưu trữ cấu trúc của database.</li>
		<li>Từng file lưu trữ cấu trúc của mỗi bảng.</li>
		<li>Khi muốn tạo 1 bảng mới, sử dụng lệnh <code>“php artisan make:migration Tênmigration --create=TênBảng”</code>.</li> 
		<li>Khi chạy sử dụng lệnh <code>“php artisan migrate”</code>.</li>
		<li>Khi thay đổi tên cột hay thuộc tính của 1 cột nào đó của bảng. Để cập nhật database, sử dụng lệnh <code>“php artisan migrate:refresh”</code>. Nhưng khi chạy lệnh này thì các dữ liệu hiện tại của bảng sẽ mất đi.</li>
	</ul>
	<p>1.2. Seeds</p>
	<ul>	
		<li>Thư mục nằm tại (../database/seeds), là 1 class chứa các dữ liệu mẫu cho database.</li>
		<li>Từng file lưu dữ liệu mẫu cho mỗi bảng.
		<li>Khi muốn tạo 1 seeds mới, sử dụng lệnh <code>“php artisan make:seed Tênseed”</code>.</li>
		<li>Nhưng để chạy được các Class seed vừa tạo. Ta phải vào file “DatabaseSeeder.php” khải báo <code>“$this->call(TenSeed::class)”</code>.</li>
		<li>Sau khi chạy lệnh <code>“php artisan migrate”</code> để tạo các bảng, giờ ta sẽ add dữ liệu mẫu vào và sử dụng lệnh <code>“php db:seed”</code>. Các dữ liệu mẫu sẽ được thêm vào bảng.</li>	
	</ul>
	

<h3>2.Hình ảnh minh họa</h3>
	<p>2.1 Tạo migrate</p>
![Imgur](https://i.imgur.com/CeCn2GZ.png)
	<p>2.2 Code migrate</p>
![Imgur](https://i.imgur.com/LfBktpY.png)
	<p>2.3 Chạy migrate</p>
![Imgur](https://i.imgur.com/WilzoZs.png)
	<p>2.4 Refresh migrate</p>
![Imgur](https://i.imgur.com/0Poo1LZ.png)
	<p>2.5 Tạo seed</p>
![Imgur](https://i.imgur.com/rBujXOR.png)
	<p>2.6 Code seed</p>
![Imgur](https://i.imgur.com/FW6U9fl.png)
	<p>2.7 Code DatabaseSeeder</p> 
![Imgur](https://i.imgur.com/a8PAe4P.png)
	<p>2.8 Chạy seed</p>
![Imgur](https://i.imgur.com/67Z6BSr.png)
	<p>2.9 Hoàn thành</p>
![Imgur](https://i.imgur.com/KuHQ7m1.png)