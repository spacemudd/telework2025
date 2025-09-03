import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "./ui/card";
import { Badge } from "./ui/badge";
import { Button } from "./ui/button";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "./ui/select";
import { MapPin, Clock, Building2, DollarSign, Calendar } from "lucide-react";

const jobListings = [
  {
    id: 1,
    title: "مطور برمجيات أول",
    company: "شركة التقنية المتقدمة",
    location: "الرياض",
    type: "دوام كامل",
    salary: "15,000 - 20,000 ريال",
    posted: "منذ يومين",
    description: "نبحث عن مطور برمجيات خبير للانضمام إلى فريقنا في تطوير حلول تقنية مبتكرة",
    skills: ["React", "Node.js", "TypeScript", "AWS"]
  },
  {
    id: 2,
    title: "مدير تسويق رقمي",
    company: "وكالة الإبداع التسويقي",
    location: "جدة",
    type: "دوام كامل",
    salary: "12,000 - 18,000 ريال",
    posted: "منذ 3 أيام",
    description: "فرصة ممتازة لقيادة استراتيجيات التسويق الرقمي لعملاء متنوعين",
    skills: ["SEO", "Google Ads", "Social Media", "Analytics"]
  },
  {
    id: 3,
    title: "محاسب قانوني",
    company: "مجموعة الشرق المالية",
    location: "الدمام",
    type: "دوام كامل",
    salary: "10,000 - 15,000 ريال",
    posted: "منذ أسبوع",
    description: "نطلب محاسب قانوني معتمد للعمل في قسم المحاسبة والمراجعة",
    skills: ["CPA", "SAP", "Excel", "Financial Reporting"]
  },
  {
    id: 4,
    title: "مصمم جرافيك",
    company: "استوديو الفن الحديث",
    location: "الرياض",
    type: "دوام جزئي",
    salary: "8,000 - 12,000 ريال",
    posted: "منذ 4 أيام",
    description: "انضم إلى فريقنا الإبداعي وساهم في تصميم هويات بصرية مميزة",
    skills: ["Adobe Creative Suite", "Figma", "Branding", "Typography"]
  },
  {
    id: 5,
    title: "مهندس شبكات",
    company: "شركة الاتصالات الذكية",
    location: "مكة المكرمة",
    type: "دوام كامل",
    salary: "14,000 - 19,000 ريال",
    posted: "منذ 5 أيام",
    description: "فرصة للعمل في تصميم وإدارة الشبكات للمشاريع الكبرى",
    skills: ["Cisco", "Network Security", "CCNP", "Troubleshooting"]
  },
  {
    id: 6,
    title: "أخصائي موارد بشرية",
    company: "مؤسسة التنمية البشرية",
    location: "المدينة المنورة",
    type: "دوام كامل",
    salary: "9,000 - 14,000 ريال",
    posted: "منذ 6 أيام",
    description: "نبحث عن أخصائي موارد بشرية لإدارة عمليات التوظيف والتطوير",
    skills: ["Recruitment", "HR Management", "Training", "Employee Relations"]
  }
];

export function JobListings() {
  return (
    <section id="jobs" className="py-16 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-12">
          <h2 className="text-3xl font-bold" style={{ color: 'rgb(31, 41, 55)' }} className="mb-4">
            أحدث الوظائف المتاحة
          </h2>
          <p className="text-gray-600 max-w-2xl mx-auto">
            اكتشف الفرص الوظيفية المتنوعة من أفضل الشركات في المملكة
          </p>
        </div>

        {/* Filters */}
        <div className="flex flex-wrap gap-4 mb-8 justify-center">
          <Select>
            <SelectTrigger className="w-48 text-right">
              <SelectValue placeholder="نوع العمل" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="fulltime">دوام كامل</SelectItem>
              <SelectItem value="parttime">دوام جزئي</SelectItem>
              <SelectItem value="contract">عقد مؤقت</SelectItem>
              <SelectItem value="remote">عمل عن بُعد</SelectItem>
            </SelectContent>
          </Select>

          <Select>
            <SelectTrigger className="w-48 text-right">
              <SelectValue placeholder="مستوى الخبرة" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="entry">مبتدئ</SelectItem>
              <SelectItem value="mid">متوسط</SelectItem>
              <SelectItem value="senior">خبير</SelectItem>
              <SelectItem value="lead">قيادي</SelectItem>
            </SelectContent>
          </Select>

          <Select>
            <SelectTrigger className="w-48 text-right">
              <SelectValue placeholder="نطاق الراتب" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="0-5000">أقل من 5,000 ريال</SelectItem>
              <SelectItem value="5000-10000">5,000 - 10,000 ريال</SelectItem>
              <SelectItem value="10000-15000">10,000 - 15,000 ريال</SelectItem>
              <SelectItem value="15000+">أكثر من 15,000 ريال</SelectItem>
            </SelectContent>
          </Select>
        </div>

        {/* Job Cards */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {jobListings.map((job) => (
            <Card key={job.id} className="hover:shadow-lg transition-shadow border border-gray-200">
              <CardHeader>
                <div className="flex justify-between items-start mb-2">
                  <Badge variant="secondary" className="text-xs">
                    {job.type}
                  </Badge>
                  <div className="flex items-center text-gray-500 text-sm">
                    <Calendar className="h-4 w-4 ml-1" />
                    {job.posted}
                  </div>
                </div>
                <CardTitle className="text-right text-lg leading-tight">
                  {job.title}
                </CardTitle>
                <CardDescription className="text-right flex items-center">
                  <Building2 className="h-4 w-4 ml-1" />
                  {job.company}
                </CardDescription>
              </CardHeader>
              <CardContent>
                <div className="space-y-3">
                  <div className="flex items-center justify-between text-sm text-gray-600">
                    <div className="flex items-center">
                      <MapPin className="h-4 w-4 ml-1" />
                      {job.location}
                    </div>
                    <div className="flex items-center" style={{ color: 'rgb(31, 41, 55)' }}>
                      <DollarSign className="h-4 w-4 ml-1" />
                      {job.salary}
                    </div>
                  </div>
                  
                  <p className="text-gray-700 text-sm text-right leading-relaxed">
                    {job.description}
                  </p>
                  
                  <div className="flex flex-wrap gap-1 justify-end">
                    {job.skills.map((skill, index) => (
                      <Badge key={index} variant="outline" className="text-xs">
                        {skill}
                      </Badge>
                    ))}
                  </div>
                  
                  <Button 
                    className="w-full mt-4" 
                    style={{ backgroundColor: 'rgb(31, 41, 55)' }}
                  >
                    عرض التفاصيل
                  </Button>
                </div>
              </CardContent>
            </Card>
          ))}
        </div>

        <div className="text-center mt-12">
          <Button 
            variant="outline" 
            size="lg"
            className="px-8"
          >
            عرض المزيد من الوظائف
          </Button>
        </div>
      </div>
    </section>
  );
}