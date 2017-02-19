<select size='6' name="id">
    <?php foreach($msgs as $msg):?>
    <option value="<?php echo $msg['id']; ?>"><?php echo $msg['title']?></option>
    <?php endforeach; ?>
</select>