<div class="col-md-10 nav_content">
    <div class="panel ">

        <?php
        if ($cur_user_role != 3) {
        ?>
        <button class="btn btn-primary">Create</button>

        <?php
        }
        ?>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Exam list
        </div>
        <div class="panel-body">
            <?php echo $title ?>
            </table>
        </div>
    </div>
</div>