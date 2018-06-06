<a href="<?= APP_URL; ?>" class="btn btn-light mb-3"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
<br>
<h1><?= $data['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
  Written by <?= $data['user']->name; ?> on <?= $data['post']->created_at; ?>
</div>
<p><?= $data['post']->body; ?></p>
<?php if($data['post']->user_id == $_SESSION['user_id']) : ?>
  <hr>
  <a class="btn btn-dark" href="<?= APP_URL; ?>/posts/edit/<?= $data['post']->id; ?>">Edit</a>
  <form class="pull-right" action="<?= APP_URL; ?>/posts/delete/<?= $data['post']->id; ?>" method="post">
    <input type="submit" class="btn btn-danger" value="Delete">
  </form>
<?php endif; ?>