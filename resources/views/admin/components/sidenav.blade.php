 <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
     <div class="sidebar-brand">
         <a href="/admin/dashboard" class="brand-link">

             <span class="brand-text fw-light">My World</span>
         </a>
     </div>
     <div class="sidebar-wrapper">
         <nav class="mt-2">
             <ul
                 class="nav sidebar-menu flex-column"
                 data-lte-toggle="treeview"
                 role="menu"
                 data-accordion="false">
                 <li class="nav-item">
                     <a href="{{route('dashboard')}}" class="nav-link  {{Request::is('admin/dashboard')?'active':''}}">
                         <i class="nav-icon bi bi-speedometer"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>

                 </li>

                 <li class="nav-item">
                     <a href="{{route('pictures.index')}}" class="nav-link {{Request::is(['admin/pictures', 'admin/pictures/*']) ? 'active' : ''}}">
                         <i class="nav-icon bi bi-images"></i>
                         <p>
                             Pictures
                         </p>
                     </a>

                 </li>

                 <li class="nav-item">
                     <a href="{{route('categories.index')}}" class="nav-link {{Request::is(['admin/categories', 'admin/categories/*']) ? 'active' : ''}}">
                         <i class="nav-icon bi bi-tags"></i>
                         <p>
                             Categories
                         </p>
                     </a>

                 </li>

                 <li class="nav-item">
                     <a href="{{route('posts.index')}}" class="nav-link {{Request::is(['admin/posts', 'admin/posts/*']) ? 'active' : ''}}">
                         <i class="nav-icon bi bi-newspaper"></i>
                         <p>
                             Posts
                         </p>
                     </a>

                 </li>

             </ul>
         </nav>
     </div>
 </aside>