<?php if($this->session->status_login == "success"):?>
<div class = "alert alert-success">
    <?php echo $this->session->msg_login;?>
</div>
<?php elseif($this->session->status_login == "error"):?>
<div class = "alert alert-danger">
    <?php echo $this->session->msg_login;?>
</div>
<?php endif;?>
<h2>WELCOME TO <i>RESULT BUILDER</i> ADMINISTRATIVE PAGE</h2>
<br/>
<h3>Quick Brief</h3>
<hr/>
<h4>The main purpose of <i>Result Builder</i> is to manage how to present the result.</h4>
<h5><i>Result Builder</i> is intended to memorize and build the dashboard based on dataset that is received from <i>Query Builder Adapter</i>. Every result has its own way to be presented therefore, it needs to be managed. This module contains ONLY <i>3 types</i> of result which are tables, widgets, and bar charts. Developer can add more presentation types later, but the default amount is 3.</h5>