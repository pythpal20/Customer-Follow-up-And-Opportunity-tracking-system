<style>
    .cssbuttons-io {
     position: relative;
     font-family: inherit;
     font-weight: 500;
     font-size: 18px;
     letter-spacing: 0.05em;
     border-radius: 0.8em;
     border: none;
     background: linear-gradient(to right, #8e2de2, #4a00e0);
     color: ghostwhite;
     overflow: hidden;
    }
    
    .cssbuttons-io svg {
     width: 1.2em;
     height: 8em;
     margin-right: 0.5em;
    }
    
    .cssbuttons-io span {
     position: relative;
     z-index: 10;
     transition: color 0.4s;
     display: inline-flex;
     align-items: center;
     padding: 0.3em 9vw 0.3em 8.8vw;
    }
    
    .cssbuttons-io::before,
    .cssbuttons-io::after {
     position: absolute;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     z-index: 0;
    }
    
    .cssbuttons-io::before {
     content: "";
     background: #4682B4;
     width: 120%;
     left: -10%;
     transform: skew(30deg);
     transition: transform 0.4s cubic-bezier(0.3, 1, 0.8, 1);
    }
    
    .cssbuttons-io:hover::before {
     transform: translate3d(100%, 0, 0);
    }
    
    .cssbuttons-io:active {
     transform: scale(0.95);
    }
    
    .card {
     border-radius: 50px;
     box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
    }
</style>
<div class="container-fluid">
    <div class="middle-box  animated fadeInDown">
        <!-- <div class="row"> -->
        <div class="col-lg-12 m-t-lg">
            <div class="ibox border-top-danger card">
                <div class="ibox-title">
                    <h5><?= $title; ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?= $this->session->flashdata('message'); ?>
                    <form class="m-t" action="<?= base_url('auth'); ?>" method="POST">
                        <div class="form-group">
                            <label>E-Mail</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email Address..." value="<?= set_value('email'); ?>">
                            <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                <div class="input-group-append">
                                    <span id="mybutton" onclick="change()" class="input-group-text">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <button type="submit"  class="cssbuttons-io text-white"><span><i class="fa fa-sign-in"></i>  LOGIN</span></button>
                    </form>
                </div>
                <div class="ibox-footer">
                    <h5 class="text-center">Sistem Informasi Follow Up Customer</h5>
                </div>
            </div>
        </div>
        <!-- </div> -->
    </div>
</div>