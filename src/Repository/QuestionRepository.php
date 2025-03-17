<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function findQuestionsGroupedByCategory()
    {
        $qb = $this->createQueryBuilder('q')
            ->select('q.category', 'q')
            ->orderBy('q.category');

        $questions = $qb->getQuery()->getResult();

        $groupedQuestions = [];
        foreach ($questions as $question) {
            $groupedQuestions[$question['category']->value][] = $question;
        }

        return $groupedQuestions;
    }
}
