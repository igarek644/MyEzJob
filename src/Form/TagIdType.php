<?php
declare(strict_types = 1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class TagIdType
 *
 * @package App\Form
 */
class TagIdType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'tag_id',
            IntegerType::class,
            ['constraints' => new Type(['type' => 'integer'])]
        );
    }
}
