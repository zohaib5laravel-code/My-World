 <!--begin::Sidebar-->
 <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
     <!--begin::Sidebar Brand-->
     <div class="sidebar-brand">
         <!--begin::Brand Link-->
         <a href="./index.html" class="brand-link">
           
             <!--begin::Brand Text-->
             <span class="brand-text fw-light">My World</span>
             <!--end::Brand Text-->
         </a>
         <!--end::Brand Link-->
     </div>
     <!--end::Sidebar Brand-->
     <!--begin::Sidebar Wrapper-->
     <div class="sidebar-wrapper">
         <nav class="mt-2">
             <!--begin::Sidebar Menu-->
             <ul
                 class="nav sidebar-menu flex-column"
                 data-lte-toggle="treeview"
                 role="menu"
                 data-accordion="false">
                 <li class="nav-item">
                     <a href="{{route('dashboard')}}" class="nav-link  {{Request::is('dashboard')?'active':''}}">
                         <i class="nav-icon bi bi-speedometer"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                    
                 </li>

                 <li class="nav-item">
                     <a href="{{route('pictures.index')}}" class="nav-link {{Request::is(['pictures', 'pictures/*']) ? 'active' : ''}}">
                         <i class="nav-icon bi bi-images"></i>
                         <p>
                             Pictures
                         </p>
                     </a>
                    
                 </li>

                 <li class="nav-item">
                     <a href="{{route('categories.index')}}" class="nav-link {{Request::is(['categories', 'categories/*']) ? 'active' : ''}}">
                         <i class="nav-icon bi bi-tags"></i>
                         <p>
                             Categories
                         </p>
                     </a>
                    
                 </li>

                 <li class="nav-item">
                     <a href="{{route('posts.index')}}" class="nav-link {{Request::is(['posts', 'posts/*']) ? 'active' : ''}}">
                         <i class="nav-icon bi bi-newspaper"></i>
                         <p>
                             Posts
                         </p>
                     </a>
                    
                 </li>
                 
             </ul>
             <!--end::Sidebar Menu-->
         </nav>
     </div>
     <!--end::Sidebar Wrapper-->
 </aside>
 <!--end::Sidebar-->