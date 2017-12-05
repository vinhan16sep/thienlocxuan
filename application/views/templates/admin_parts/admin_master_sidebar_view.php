<?php
if($this->ion_auth->logged_in()) {
?>
<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
            <li class="sub-menu">
                <a href="<?php echo site_url('admin/banner'); ?>" class="">
                    <i class="icon_document_alt"></i>
                    <span>Slide</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="<?php echo site_url('admin/cover'); ?>" class="">
                    <i class="icon_document_alt"></i>
                    <span>Cover</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="<?php echo site_url('admin/partner'); ?>" class="">
                    <i class="icon_document_alt"></i>
                    <span>Đối tác</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="#" class="">
                    <i class="icon_document_alt"></i>
                    <span>Giới thiệu</span>
                </a>
                <ul>
                    <li class="sub-menu">
                        <a href="<?php echo site_url('admin/history'); ?>" class="">
                            <i class="icon_document_alt"></i>
                            <span>Lịch sử</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="<?php echo site_url('admin/member'); ?>" class="">
                            <i class="icon_document_alt"></i>
                            <span>Nhân sự</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="#" class="">
                    <i class="icon_document_alt"></i>
                    <span>Chỉnh sửa thuốc</span>
                </a>
                <ul>
                    <li class="sub-menu">
                        <a href="<?php echo site_url('admin/physic'); ?>" class="">
                            <i class="icon_document_alt"></i>
                            <span>Thuốc</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="<?php echo site_url('admin/physictype'); ?>" class="">
                            <i class="icon_document_alt"></i>
                            <span>Loại</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="<?php echo site_url('admin/physicgroup'); ?>" class="">
                            <i class="icon_document_alt"></i>
                            <span>Nhóm</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="#" class="">
                    <i class="icon_document_alt"></i>
                    <span>Chỉnh sửa TPCN</span>
                </a>
                <ul>
                    <li class="sub-menu">
                        <a href="<?php echo site_url('admin/product'); ?>" class="">
                            <i class="icon_document_alt"></i>
                            <span>TP chức năng</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="<?php echo site_url('admin/type'); ?>" class="">
                            <i class="icon_document_alt"></i>
                            <span>Loại</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="<?php echo site_url('admin/group'); ?>" class="">
                            <i class="icon_document_alt"></i>
                            <span>Nhóm</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="<?php echo site_url('admin/blog'); ?>" class="">
                    <i class="icon_document_alt"></i>
                    <span>Blog</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="<?php echo site_url('admin/recruitment'); ?>" class="">
                    <i class="icon_document_alt"></i>
                    <span>Tuyển dụng</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="<?php echo site_url('admin/qa'); ?>" class="">
                    <i class="icon_document_alt"></i>
                    <span>Câu hỏi thường gặp</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="#" class="">
                    <i class="icon_document_alt"></i>
                    <span>Đ/k nhận báo giá</span>
                </a>
                <ul>
                    <li class="sub-menu">
                        <a href="<?php echo site_url('admin/quotation'); ?>" class="">
                            <i class="icon_document_alt"></i>
                            <span>Chờ duyệt</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="<?php echo site_url('admin/quotation/approve_list'); ?>" class="">
                            <i class="icon_document_alt"></i>
                            <span>Đã đồng ý</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="<?php echo site_url('admin/quotation/reject_list'); ?>" class="">
                            <i class="icon_document_alt"></i>
                            <span>Đã từ chối</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<?php } ?>



