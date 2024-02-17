<?php $se = session()->get('class'); ?>
<style>
  ._row {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    gap: .5rem;
  }

  .radio-label {
    display: flex;
    align-items: center;
  }

  .svg-fix:not(.stroke-on-tertiary) {
    stroke: black;
    width: 2.25rem;
  }

  .stroke-on-tertiary {
    stroke: var(--md-sys-color-on-tertiary);
  }
</style>
<?php helper('flipWordsForArabic'); ?>
<md-fab label='<?php echo lang('General.Menu') ?>' onclick="submenu.show()" variant="primary" class="pointer">
  <md-icon slot="icon">
    <i class="bi bi-menu-up"></i>
  </md-icon>
</md-fab>


<nav id="_drawer" class="hide" data-visible="false" data-side="false">
  <div id="_popup">
    <div id="nav-container">
      <p><?php echo lang('General.menuSection') ?></p>
      <a href="<?php echo base_url($locale . '/students') ?>" class="nav-item <?php if ($from == 'students') echo 'tertiary on-tertiary-text' ?>">
        <md-ripple></md-ripple>
        <div class="_icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="white" stroke-linecap="round" stroke-linejoin="round" class="icon">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
          </svg>
        </div>
        <p class="label"><?php echo lang('Students.students') ?></p>
      </a>
      <a href="<?php echo base_url($locale . '/subjects') ?>" class="nav-item <?php if ($from == 'subjects') echo 'tertiary on-tertiary-text' ?>">
        <md-ripple></md-ripple>
        <div class="_icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path>
            <path d="M9 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path>
            <path d="M5 8h4"></path>
            <path d="M9 16h4"></path>
            <path d="M13.803 4.56l2.184 -.53c.562 -.135 1.133 .19 1.282 .732l3.695 13.418a1.02 1.02 0 0 1 -.634 1.219l-.133 .041l-2.184 .53c-.562 .135 -1.133 -.19 -1.282 -.732l-3.695 -13.418a1.02 1.02 0 0 1 .634 -1.219l.133 -.041z">
            </path>
            <path d="M14 9l4 -1"></path>
            <path d="M16 16l3.923 -.98"></path>
          </svg>
        </div>
        <p class="label"><?php echo lang('Subjects.Subjects') ?></p>
      </a>
      <a href="<?php echo base_url($locale . '/classes') ?>" class="nav-item <?php if ($from == 'classes') echo 'tertiary on-tertiary-text' ?>">
        <md-ripple></md-ripple>
        <div class="_icon">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chalkboard" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M8 19h-3a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v11a1 1 0 0 1 -1 1"></path>
            <path d="M11 16m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path>
          </svg>

        </div>
        <p class="label"><?php echo lang('General.Classes') ?></p>
      </a>
      <md-divider></md-divider>
      <p><?php echo lang('General.Task') ?></p>
      <?php if ($from == "subjects") : ?>

        <a href="<?php echo base_url($locale . '/subjects/manage_subject') ?>" class="nav-item <?php if ($page_name == 'manage_student') echo 'on-tertiary-text  tertiary';
                                                                                                else echo 'on-surface-text' ?>">
          <md-ripple></md-ripple>
          <div class="_icon">
            <i class="bi bi-columns-gap"></i>
          </div>
          <p class="label"><?php echo lang('General.Manage') . ' ' . lang('Subjects.Subjects') ?></p>
        </a>
        <a href="<?php echo base_url($locale . '/subjects/add_sum') ?>" class="nav-item  <?php if ($page_name == 'add_sum') echo 'on-tertiary-text  tertiary';
                                                                                          else echo 'on-surface-text' ?>">
          <md-ripple></md-ripple>
          <div class="_icon">
            <i class="bi bi-table"></i>
          </div>
          <p class="label"><?php echo lang('Subjects.createMirror') ?></p>
        </a>
        <a href="<?php echo base_url($locale . '/subjects/sum') ?>" class="nav-item <?php if ($page_name == 'sum')
                                                                                      echo 'on-tertiary-text  tertiary';
                                                                                    else
                                                                                      echo 'on-surface-text' ?>">
          <md-ripple></md-ripple>
          <div class="_icon">
            <i class="bi bi-file-earmark-medical"></i>
          </div>
          <p class="label"><?php echo lang('Subjects.Mirrors') ?></p>
        </a>
        <a href="<?php echo base_url($locale . '/subjects/order') ?>" class="nav-item <?php if ($page_name == 'order')
                                                                                        echo 'on-tertiary-text  tertiary';
                                                                                      else
                                                                                        echo 'on-surface-text' ?>">
          <md-ripple></md-ripple>
          <div class="_icon">
            <i class="bi bi-sort-numeric-down"></i>
          </div>
          <p class="label"><?php echo flipWords(lang('Subjects.Subjects'), lang('General.order')) ?></p>
        </a>
      <?php elseif ($from == "students") : ?>
        <a href="<?php echo base_url($locale . '/students/manage_student') ?>" class="nav-item <?php if ($page_name == 'manage_student')
                                                                                                  echo 'on-tertiary-text  tertiary';
                                                                                                else
                                                                                                  echo 'on-surface-text' ?>">
          <md-ripple></md-ripple>
          <div class="_icon">
            <i class="bi bi-people"></i>
          </div>
          <p class="label"><?php echo lang('General.Manage') . ' ' . lang('Students.Students') ?></p>
        </a>
        <a href="<?php echo base_url($locale . '/students/edit_behav') ?>" class="nav-item <?php if ($page_name == 'edit_behav')
                                                                                              echo 'on-tertiary-text  tertiary';
                                                                                            else
                                                                                              echo 'on-surface-text' ?>">
          <md-ripple></md-ripple>
          <div class="_icon">
            <i class="bi bi-person-check"></i>
          </div>
          <p class="label"><?php echo lang('Students.Behav')?></p>
        </a>
        <a href="<?php echo base_url($locale . '/students/edit_absent') ?>" class="nav-item <?php if ($page_name == 'edit_absent')
                                                                                              echo 'on-tertiary-text  tertiary';
                                                                                            else
                                                                                              echo 'on-surface-text' ?>">
          <md-ripple></md-ripple>
          <div class="_icon">
            <i class="bi bi-person-check"></i>
          </div>
          <p class="label"><?php echo lang('Students.Absent')?></p>
        </a>
        <a href="<?php echo base_url($locale . '/students/cert') ?>" class="nav-item on-surface-text">
          <md-ripple></md-ripple>
          <div class="_icon">
            <i class="bi bi-printer"></i>
          </div>
          <p class="label"><?php echo lang('Students.Certificates')?></p>
        </a>
      <?php endif; ?>
      <md-divider></md-divider>
      <p><?php echo lang('General.other')?></p>
      <a href="<?php echo base_url($locale . '/settings') ?>" class="nav-item <?php if ($page_name == 'settings')
                                                                                echo 'tertiary on-tertiary-text stroke-on-tertiary' ?>">
        <md-ripple></md-ripple>
        <div class="_icon">
          <i>
            <svg class="svg-fix" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
              <g id="SVGRepo_iconCarrier">
                <circle cx="12" cy="12" r="3" stroke="#1C274C" stroke-width="1.5"></circle>
                <path opacity="0.5" d="M13.7654 2.15224C13.3978 2 12.9319 2 12 2C11.0681 2 10.6022 2 10.2346 2.15224C9.74457 2.35523 9.35522 2.74458 9.15223 3.23463C9.05957 3.45834 9.0233 3.7185 9.00911 4.09799C8.98826 4.65568 8.70226 5.17189 8.21894 5.45093C7.73564 5.72996 7.14559 5.71954 6.65219 5.45876C6.31645 5.2813 6.07301 5.18262 5.83294 5.15102C5.30704 5.08178 4.77518 5.22429 4.35436 5.5472C4.03874 5.78938 3.80577 6.1929 3.33983 6.99993C2.87389 7.80697 2.64092 8.21048 2.58899 8.60491C2.51976 9.1308 2.66227 9.66266 2.98518 10.0835C3.13256 10.2756 3.3397 10.437 3.66119 10.639C4.1338 10.936 4.43789 11.4419 4.43786 12C4.43783 12.5581 4.13375 13.0639 3.66118 13.3608C3.33965 13.5629 3.13248 13.7244 2.98508 13.9165C2.66217 14.3373 2.51966 14.8691 2.5889 15.395C2.64082 15.7894 2.87379 16.193 3.33973 17C3.80568 17.807 4.03865 18.2106 4.35426 18.4527C4.77508 18.7756 5.30694 18.9181 5.83284 18.8489C6.07289 18.8173 6.31632 18.7186 6.65204 18.5412C7.14547 18.2804 7.73556 18.27 8.2189 18.549C8.70224 18.8281 8.98826 19.3443 9.00911 19.9021C9.02331 20.2815 9.05957 20.5417 9.15223 20.7654C9.35522 21.2554 9.74457 21.6448 10.2346 21.8478C10.6022 22 11.0681 22 12 22C12.9319 22 13.3978 22 13.7654 21.8478C14.2554 21.6448 14.6448 21.2554 14.8477 20.7654C14.9404 20.5417 14.9767 20.2815 14.9909 19.902C15.0117 19.3443 15.2977 18.8281 15.781 18.549C16.2643 18.2699 16.8544 18.2804 17.3479 18.5412C17.6836 18.7186 17.927 18.8172 18.167 18.8488C18.6929 18.9181 19.2248 18.7756 19.6456 18.4527C19.9612 18.2105 20.1942 17.807 20.6601 16.9999C21.1261 16.1929 21.3591 15.7894 21.411 15.395C21.4802 14.8691 21.3377 14.3372 21.0148 13.9164C20.8674 13.7243 20.6602 13.5628 20.3387 13.3608C19.8662 13.0639 19.5621 12.558 19.5621 11.9999C19.5621 11.4418 19.8662 10.9361 20.3387 10.6392C20.6603 10.4371 20.8675 10.2757 21.0149 10.0835C21.3378 9.66273 21.4803 9.13087 21.4111 8.60497C21.3592 8.21055 21.1262 7.80703 20.6602 7C20.1943 6.19297 19.9613 5.78945 19.6457 5.54727C19.2249 5.22436 18.693 5.08185 18.1671 5.15109C17.9271 5.18269 17.6837 5.28136 17.3479 5.4588C16.8545 5.71959 16.2644 5.73002 15.7811 5.45096C15.2977 5.17191 15.0117 4.65566 14.9909 4.09794C14.9767 3.71848 14.9404 3.45833 14.8477 3.23463C14.6448 2.74458 14.2554 2.35523 13.7654 2.15224Z" stroke="#1C274C" stroke-width="1"></path>
              </g>
            </svg></i>
        </div>
        <p class="label"><?php echo lang('General.Settings')?></p>
      </a>
      <a href="<?php echo base_url('BackupDb') ?>" class="nav-item">
        <md-ripple></md-ripple>
        <div class="_icon">
          <i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-check" viewBox="0 0 16 16">
              <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514Z" />
              <path d="M12.096 6.223A4.92 4.92 0 0 0 13 5.698V7c0 .289-.213.654-.753 1.007a4.493 4.493 0 0 1 1.753.25V4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.525 4.525 0 0 1-.813-.927C8.5 14.992 8.252 15 8 15c-1.464 0-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13h.027a4.552 4.552 0 0 1 0-1H8c-1.464 0-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10c.262 0 .52-.008.774-.024a4.525 4.525 0 0 1 1.102-1.132C9.298 8.944 8.666 9 8 9c-1.464 0-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777ZM3 4c0-.374.356-.875 1.318-1.313C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4Z" />
            </svg></i>
        </div>
        <p class="label"><?php echo lang('General.backUp')?></p>
      </a>
      <a href="<?php echo base_url($locale . '/hide') ?>" class="nav-item <?php if ($page_name == 'hide')
                                                                            echo 'tertiary on-tertiary-text stroke-on-tertiary' ?>">
        <md-ripple></md-ripple>
        <div class="_icon">
          <i><svg class="svg-fix" style="scale: .75" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
              <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
              <g id="SVGRepo_iconCarrier">
                <g id="Edit / Hide">
                  <path id="Vector" d="M3.99989 4L19.9999 20M16.4999 16.7559C15.1473 17.4845 13.6185 17.9999 11.9999 17.9999C8.46924 17.9999 5.36624 15.5478 3.5868 13.7788C3.1171 13.3119 2.88229 13.0784 2.7328 12.6201C2.62619 12.2933 2.62616 11.7066 2.7328 11.3797C2.88233 10.9215 3.11763 10.6875 3.58827 10.2197C4.48515 9.32821 5.71801 8.26359 7.17219 7.42676M19.4999 14.6335C19.8329 14.3405 20.138 14.0523 20.4117 13.7803L20.4146 13.7772C20.8832 13.3114 21.1182 13.0779 21.2674 12.6206C21.374 12.2938 21.3738 11.7068 21.2672 11.38C21.1178 10.9219 20.8827 10.6877 20.4133 10.2211C18.6338 8.45208 15.5305 6 11.9999 6C11.6624 6 11.3288 6.02241 10.9999 6.06448M13.3228 13.5C12.9702 13.8112 12.5071 14 11.9999 14C10.8953 14 9.99989 13.1046 9.99989 12C9.99989 11.4605 10.2135 10.9711 10.5608 10.6113" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path>
                </g>
              </g>
            </svg></i>
        </div>
        <p class="label"><?php echo lang('General.Hide') .' '. lang('Students.Students')?></p>
      </a>
      <a href="<?php echo base_url('login/logout') ?>" class="nav-item">
        <md-ripple></md-ripple>
        <div class="_icon">
          <i class="bi bi-box-arrow-in-left"></i>
        </div>
        <p class="label"><?php echo lang('General.signup')?> </p>
      </a>
      <md-divider></md-divider>
      <button class="nav-item primary-container on-primary-container-text" onclick="get_cert()" style="border: none;width:calc(100% / var(--items) - ((var(--items) - 1) * 10px) / var(--items)  );justify-content: center;align-items: center;">
      <?php echo lang('General.MakeCertificateForStudent')?>
      </button>

      <input list="students" placeholder="<?php echo lang('Students.studentName') ?>" class="nav-item" id="std_cert" style="border: none;width:calc(100% / var(--items) - ((var(--items) - 1) * 10px) / var(--items)  );text-align: center;">
      <script>
        function get_cert() {
          let std_name = document.getElementById(`std_cert`).value;
          let std_id = document.querySelector(`option[value="${std_name}"]`).id
          window.location = app.baseUrl + "/<?php echo $locale ?>/students/certificate/" + std_id
        }
      </script>
      <md-divider></md-divider>
      <div class="nav-item fluid noicon">
        <div class="_row">
          <div class="radio-label">
            <md-radio <?php echo ($se == 'c10') ? 'checked' : '' ?> id="c10" onchange="app.change_class(this.id)" name='cls' touch-target="wrapper">
            </md-radio>
            <label for="c10" class="pointer">
              الأول الثانوي التجاري
            </label>
          </div>
          <div class="radio-label">
            <md-radio <?php echo ($se == 'c11') ? 'checked' : '' ?> id="c11" onchange="app.change_class(this.id)" name='cls' touch-target="wrapper">
            </md-radio>
            <label for="c11" class="pointer">
              الثاني الثانوي التجاري
            </label>
          </div>
          <div class="radio-label">
            <md-radio <?php echo ($se == 'c12') ? 'checked' : '' ?> id="c12" onchange="app.change_class(this.id)" name='cls' touch-target="wrapper">
            </md-radio>
            <label for="c12" class="pointer">
              الثالث الثانوي التجاري
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    const submenu = {
      menu: document.querySelector('#_drawer'),
      visible: 0,
      show: () => {
        document.body.style.overflow = 'hidden'
        submenu.menu.classList.remove('hide')
        setTimeout(() => {
          submenu.menu.dataset.visible = 'true'
        }, 1);
        return submenu.visible = 1
      },
      hide: () => {
        document.body.style.overflow = 'auto'
        submenu.menu.dataset.visible = 'false'
        setTimeout(() => {
          submenu.menu.classList.add('hide')
        }, 150);
        return submenu.visible = 0
      },
      toggle: () => submenu.visible ? submenu.hide() : submenu.show()
    }
    submenu.menu.onclick = e => (e.target.id === '_drawer' && submenu.hide(), true)
  </script>
</nav>