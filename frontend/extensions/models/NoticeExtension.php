<?php

namespace frontend\extensions\models;

use common\models\Notice;
use Yii;
use yii\db\Exception;

class NoticeExtension extends Notice
{
    const CATEGORY_MESSAGE = 1;
    const CATEGORY_ACTION = 2;
    const CATEGORY_RESPONSE = 3;
    const FROM = 'task-force@academy.ru';

    public $class = [
        '1' => 'lightbulb__new-task--message',
        '2' => 'lightbulb__new-task--executor',
        '3' => 'lightbulb__new-task--close'
    ];

    /**
     * Add status disable
     *
     * @param $notice
     * @return bool
     */

    public static function hidden(Notice $notice): bool
    {
        $notice->visible = false;
        return $notice->save();
    }

    /**
     * Get visible notice current user
     *
     * @param $id
     * @return bool
     */

    public static function getVisibleNoticesByUser($id): bool
    {
        return self::find()
            ->where([
                'visible' => true,
                'user_id' => $id
            ])
            ->exists();
    }

    /**
     * @param int $userID
     * @param int $categoryID
     * @throws Exception
     * @throws \Exception
     */
    public static function create(int $userID, int $categoryID)
    {
        $notice = new self([
            'user_id' => $userID,
            'visible' => true,
            'notice_category_id' => $categoryID,
            'message' => 'new response'
        ]);

        if($notice->save()) {
            $notice->send();
        } else {
            throw new Exception('Notice not saved');
        }
    }

    /**
     * Sending message
     * @throws \Exception
     */
    protected function send(): bool
    {
        $message = Yii::$app->mailer->compose()
            ->setFrom(self::FROM)
            ->setTo($this->user->email)
            ->setSubject($this->noticeCategory->name)
            ->setHtmlBody('<p>Received a new response to your assignment from ' . $this->user->full_name . '</p>');

        if($message->send()) {
            return true;
        } else {
            throw new \Exception('Mail is not send');
        }
    }
}
