<?php

namespace App\Form;

use App\Entity\HistoriqueEncheres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

class HistoriqueEncheresType extends AbstractType
{
    private $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

            $builder
                //->add('dateEnchere')
                ->add('prix', IntegerType::class, [
                        'label' => 'Prix de votre enchère',
                        'empty_data' => 0.5,
                ])
                //->add('user')
               /* ->add('enchere')*/
            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HistoriqueEncheres::class,
        ]);
    }
}
