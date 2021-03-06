<!-- Page title -->
<div class="page-header">
   <div class="row align-items-center">
      <div class="col-auto">
         <ol class="breadcrumb" aria-label="breadcrumbs">
            <li class="breadcrumb-item"><a href="<?=PROOT?>/dashboard">Bảng điều khiển</a></li>
            <li class="breadcrumb-item"><a href="<?=PROOT?>/settings/general">Cài đặt</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0)">Proxy</a></li>
         </ol>
      </div>
   </div>
</div>
<!-- Content here -->
<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" id="">
   <div class="row">
      <div class="col-md-4">
         <div class="card">
            <div class="card-header">
               <h3 class="card-title">Danh sách proxy hoạt động (<?=$nap?>)</h3>
            </div>
            <div class="card-body">
               <div class="form-group mb-3">
                  <textarea class="form-control" name="activeProxy" id="proxy-list"  placeholder="" rows="18" ><?=$activeProxy?></textarea>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-4">
         <div class="card">
            <div class="card-header">
               <h3 class="card-title">Danh sách proxy bị hỏng (<?=$nbp?>)</h3>
            </div>
            <div class="card-body">
               <div class="form-group mb-3">
                  <textarea class="form-control" name="brokenProxy"   placeholder="" rows="18" ><?=$brokenProxy?></textarea>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-4">
         <div class="card">
            <div class="card-header">
               <h3 class="card-title">Xác thực proxy </h3>
            </div>
            <div class="card-body">
               <div class="form-group text-right">
                  <button type="button" class="btn btn-warning btn-sm" id="check-proxy">Kiểm tra proxy</button>
               </div>
               <div class="proxy-progress d-none my-3">
                  <div class="text-muted" style="    display: flex;
                     justify-content: space-between;">
                     <div>
                        <span class="p-proxy">0</span>/<span  class="t-proxy">0</span>
                     </div>
                     <div> <span class="p-valume"></span> </div>
                  </div>
                  <div class="progress progress-sm ">
                     <div class="progress-bar" style="width: 0%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                     </div>
                  </div>
               </div>
               <div class="mb-3">
                  <label class="form-label">Tên người dùng máy chủ proxy : </label>
                  <input type="text" class="form-control" name="proxyUser" value="<?=$this->config['proxyUser']?>" placeholder="người dùng proxy">
               </div>
               <div class="mb-3">
                  <label class="form-label">Mật khẩu máy chủ proxy : </label>
                  <input type="text" class="form-control" name="proxyPass" value="<?=$this->config['proxyPass']?>"  placeholder="**********">
               </div>
               <div class="form-footer">
                  <button type="submit" class="btn btn-primary btn-block">Lưu</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>