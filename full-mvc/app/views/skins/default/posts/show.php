<a href="<?php echo APP_URL; ?>" class="btn btn-light mb-3"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
<br>
<h1><?php echo $data['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
  Written by <?php echo $data['user']->name; ?> on <?php echo $data['post']->created_at; ?>
</div>
<p><?php echo $data['post']->body; ?></p>
<?php if($data['post']->user_id == $_SESSION['user_id']) : ?>
  <hr>
  <a class="btn btn-dark" href="<?php echo APP_URL; ?>/posts/edit/<?php echo $data['post']->id; ?>">Edit</a>

  <form class="pull-right" action="<?php echo APP_URL; ?>/posts/delete/<?php echo $data['post']->id; ?>" method="post">
    <input type="submit" class="btn btn-danger" value="Delete">
  </form>
<?php endif; ?>