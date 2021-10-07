<span>

    <?php
    use App\Repository\NotificationAdminRepository;
    use App\Models\NotificationAdmin;

    $NotificationAdminRepository = new NotificationAdminRepository(new NotificationAdmin());

    $title = trans('notification_admin.' . $NotificationAdminRepository->point_type_to_title($type), $data, app()->getLocale());
    echo $title;
    ?>
</span>