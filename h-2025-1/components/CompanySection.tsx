import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "./ui/card";
import { Button } from "./ui/button";
import { Badge } from "./ui/badge";
import { Building2, Users, TrendingUp, Clock, Check, Star } from "lucide-react";

const plans = [
  {
    name: "الخطة الأساسية",
    price: "499",
    period: "شهرياً",
    description: "مثالية للشركات الصغيرة",
    features: [
      "نشر حتى 5 وظائف شهرياً",
      "عرض في نتائج البحث",
      "دعم فني أساسي",
      "تقارير أساسية"
    ],
    popular: false
  },
  {
    name: "الخطة الاحترافية",
    price: "999",
    period: "شهرياً",
    description: "الأفضل للشركات المتوسطة",
    features: [
      "نشر حتى 20 وظيفة شهرياً",
      "أولوية في نتائج البحث",
      "دعم فني مخصص",
      "تقارير تفصيلية",
      "أدوات فلترة متقدمة",
      "صفحة شركة مخصصة"
    ],
    popular: true
  },
  {
    name: "خطة المؤسسات",
    price: "تواصل معنا",
    period: "",
    description: "حلول مخصصة للمؤسسات الكبيرة",
    features: [
      "وظائف غير محدودة",
      "أولوية قصوى في العرض",
      "مدير حساب مخصص",
      "تقارير وتحليلات متقدمة",
      "تكامل مع أنظمة HR",
      "تدريب للفريق",
      "دعم فني 24/7"
    ],
    popular: false
  }
];

export function CompanySection() {
  return (
    <section id="companies" className="py-20 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center mb-16">
          <h2 className="text-4xl font-bold mb-6" style={{ color: 'rgb(31, 41, 55)' }}>
            هل تبحث عن موظفين؟
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
            انضم الى هدف و اعثر على افضل المواهب لفريقك
          </p>
          
          {/* Stats for Companies */}
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
            <div className="text-center">
              <div className="bg-blue-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <Users className="h-8 w-8 text-blue-600" />
              </div>
              <h3 className="text-2xl font-bold mb-2" style={{ color: 'rgb(31, 41, 55)' }}>+50,000</h3>
              <p className="text-gray-600">باحث عن عمل نشط</p>
            </div>
            <div className="text-center">
              <div className="bg-green-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <TrendingUp className="h-8 w-8 text-green-600" />
              </div>
              <h3 className="text-2xl font-bold mb-2" style={{ color: 'rgb(31, 41, 55)' }}>85%</h3>
              <p className="text-gray-600">معدل نجاح التوظيف</p>
            </div>
            <div className="text-center">
              <div className="bg-purple-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <Building2 className="h-8 w-8 text-purple-600" />
              </div>
              <h3 className="text-2xl font-bold mb-2" style={{ color: 'rgb(31, 41, 55)' }}>+200</h3>
              <p className="text-gray-600">شركة تثق بنا</p>
            </div>
            <div className="text-center">
              <div className="bg-orange-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <Clock className="h-8 w-8 text-orange-600" />
              </div>
              <h3 className="text-2xl font-bold mb-2" style={{ color: 'rgb(31, 41, 55)' }}>15</h3>
              <p className="text-gray-600">يوم متوسط مدة التوظيف</p>
            </div>
          </div>
        </div>

        {/* Pricing Plans */}
        <div className="mb-16">
          <h3 className="text-2xl font-bold text-center mb-12" style={{ color: 'rgb(31, 41, 55)' }}>
            اختر الخطة المناسبة لشركتك
          </h3>
          
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            {plans.map((plan, index) => (
              <Card 
                key={index} 
                className={`relative ${plan.popular ? 'border-2 shadow-xl' : 'border'}`}
                style={plan.popular ? { borderColor: 'rgb(31, 41, 55)' } : {}}
              >
                {plan.popular && (
                  <div className="absolute -top-4 right-1/2 transform translate-x-1/2">
                    <Badge 
                      className="px-4 py-1"
                      style={{ backgroundColor: 'rgb(31, 41, 55)' }}
                    >
                      <Star className="h-3 w-3 ml-1" />
                      الأكثر شعبية
                    </Badge>
                  </div>
                )}
                
                <CardHeader className="text-center pb-8">
                  <CardTitle className="text-xl mb-2">{plan.name}</CardTitle>
                  <div className="mb-4">
                    <span className="text-4xl font-bold" style={{ color: 'rgb(31, 41, 55)' }}>
                      {plan.price === "تواصل معنا" ? "" : plan.price + " ريال"}
                    </span>
                    {plan.price === "تواصل معنا" ? (
                      <span className="text-2xl" style={{ color: 'rgb(31, 41, 55)' }}>
                        {plan.price}
                      </span>
                    ) : (
                      <span className="text-gray-600">/{plan.period}</span>
                    )}
                  </div>
                  <CardDescription className="text-center">
                    {plan.description}
                  </CardDescription>
                </CardHeader>
                
                <CardContent>
                  <ul className="space-y-3 mb-8">
                    {plan.features.map((feature, featureIndex) => (
                      <li key={featureIndex} className="flex items-center text-right">
                        <Check className="h-5 w-5 text-green-500 ml-3 flex-shrink-0" />
                        <span className="text-gray-700">{feature}</span>
                      </li>
                    ))}
                  </ul>
                  
                  <Button 
                    className="w-full"
                    variant={plan.popular ? "default" : "outline"}
                    style={plan.popular ? { backgroundColor: 'rgb(31, 41, 55)' } : {}}
                  >
                    {plan.price === "تواصل معنا" ? "تواصل معنا" : "اختر هذه الخطة"}
                  </Button>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>

        {/* Call to Action */}
        <div className="text-center bg-gray-50 rounded-2xl p-12">
          <h3 className="text-2xl font-bold mb-4" style={{ color: 'rgb(31, 41, 55)' }}>
            ابدأ في نشر وظائفك اليوم
          </h3>
          <p className="text-gray-600 mb-8 max-w-2xl mx-auto">
            انضم إلى مئات الشركات التي تثق في منصتنا للعثور على أفضل المواهب
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button 
              size="lg" 
              className="px-8"
              style={{ backgroundColor: 'rgb(31, 41, 55)' }}
            >
              إنشاء حساب شركة
            </Button>
            <Button variant="outline" size="lg" className="px-8">
              جدولة عرض توضيحي
            </Button>
          </div>
        </div>
      </div>
    </section>
  );
}