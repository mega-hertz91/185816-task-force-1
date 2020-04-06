<?php

namespace frontend\services;

use Exception;
use frontend\models\Comment;
use frontend\models\Task;
use frontend\models\User;

class CreateComment
{
    public $comment;
    const MESSAGE_FAILED = 'Задание провалено';
    const RATING_DEFAULT = 1;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param Task $task
     * @throws Exception
     */

    public function addNewFailedComment(Task $task): void
    {
        $this->comment->task_id = $task->id;
        $this->comment->user_id = $task->user_id;
        $this->comment->executor_id = $task->executor_id;
        $this->comment->description = self::MESSAGE_FAILED;
        $this->comment->rating = self::RATING_DEFAULT;
        if (!$this->comment->save()) {
            throw new Exception('Не удалось сохранить комментарий');
        }
    }

    /**
     * @param Task $task
     * @throws Exception
     */

    public function addNewCompleteComment(Task $task): void
    {
        $this->comment->task_id = $task->id;
        $this->comment->user_id = $task->user_id;
        $this->comment->executor_id = $task->executor_id;

        if (!$this->comment->save()) {
            throw new Exception('Не удалось сохранить комментарий');
        }
    }

    /**
     * @param User $user
     * @return int|mixed
     */

    public function getRating(User $user)
    {
        $rating = $this->comment::find()
            ->select(['executor_id', 'rating' => 'avg(rating)'])
            ->groupBy('executor_id')
            ->where(['executor_id' => $user->id])
            ->asArray(true)->all();

        if(!empty($rating)) {
            return $rating[0]['rating'];
        } else {
            return 0;
        }
    }
}
