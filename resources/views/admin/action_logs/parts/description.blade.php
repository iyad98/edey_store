<span>

    <?php
    use App\Repository\NotificationAdminRepository;
    use App\Models\NotificationAdmin;

    $NotificationAdminRepository = new NotificationAdminRepository(new NotificationAdmin());

    $sub_title = trans('notification_admin.' . $NotificationAdminRepository->point_type_to_description($type), $data, app()->getLocale());
    $url = $NotificationAdminRepository->point_type_to_url($type , $order_id);
    ?>
    <a href="{{$url}}">{{$sub_title}}</a>
</span>