<div class="col-md-10 nav_content">
    <div class="panel ">

        <?php
        if ($cur_user['role_id'] != 3) {
        ?>
            <button class="btn btn-primary">Create</button>

        <?php
        }
        ?>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Question list
        </div>
        <div class="panel-body">

            </table>
        </div>
    </div>
</div>